@extends('layouts.master')

@section('title', 'Airports')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

<style>
    #map {
        height: 700px;
    }
    .filter-container {
        margin-bottom: 20px;
        background-color: #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,.1);
    }
    .form-check-scrollable {
        max-height: 150px;
        overflow-y: auto;
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
    }
    .total-airports {
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.2);
        font-weight: bold;
    }

    .select2-container .select2-selection--single {
        height: 45px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 10px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 30px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 45px;
        right: 10px;
    }
</style>
@endpush

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3 style="text-align: center;">Papua New Guinea Airports</h3>
    </div>

    <div class="filter-container p-3">
        <form id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="name" class="form-label">Airport Name</label>
                    <select id="name" class="form-select select2-search" name="name">
                        <option value="">🔍 All Airports</option>
                        @foreach($airportNames as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" class="form-select select2-search" name="category">
                        <option value="">🔍 All Categories</option>
                        @foreach($airportCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="location" class="form-label">Location</label>
                    <select id="location" class="form-select select2-search" name="location">
                        <option value="">🔍 All Locations</option>
                        @foreach($airportLocations as $location)
                            <option value="{{ $location }}">{{ $location }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="radiusRange" class="form-label">Search in radius <span id="radiusValue">0</span> kilometers</label>
                    <input type="range" id="radiusRange" name="radius" class="form-control" min="0" max="200" value="0">
                </div>

                <div class="col-md-6">
                    <label class="form-label"><strong>Provinces Region</strong></label>
                    <div class="form-check-scrollable">
                        @foreach ($provinces as $province)
                            <div class="form-check">
                                <input class="form-check-input province-checkbox" type="checkbox" name="provinces[]" value="{{ $province->id }}" id="province_{{ $province->id }}">
                                <label class="form-check-label" for="province_{{ $province->id }}">
                                    {{ $province->provinces_region }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-12 text-end">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                    <button type="button" id="resetFilter" class="btn btn-secondary">Reset Filter</button>
                </div>
            </div>
        </form>
    </div>

    <div id="map"></div>
</div>

@endsection

@push('service')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const map = L.map('map').setView([-6.80188562253168, 144.0733101155011], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors',
        maxZoom: 19,
    }).addTo(map);

    let airportMarkers = L.featureGroup().addTo(map);
    let centerMarker = null;
    let lastClickedAirport = null;
    let destinationMarker = null;
    let destinationCoordinates = null;
    let drawnPolygonGeoJSON = null; // Changed from window.drawnPolygon to a local variable

    const drawnItems = new L.FeatureGroup().addTo(map);

    const drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            polyline: false,
            rectangle: true,
            circle: false,
            marker: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true
        }
    });
    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, function (event) {
        const layer = event.layer;
        drawnItems.clearLayers();
        drawnItems.addLayer(layer);
        drawnPolygonGeoJSON = layer.toGeoJSON();
        applyFilters();
    });

    map.on(L.Draw.Event.EDITED, function (event) {
        const layers = event.layers;
        layers.eachLayer(function (layer) {
            drawnPolygonGeoJSON = layer.toGeoJSON();
        });
        applyFilters();
    });

    map.on(L.Draw.Event.DELETED, function (event) {
        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null;
        applyFilters();
    });

    const totalControl = L.control({ position: 'topright' });
    totalControl.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'total-airports');
        div.innerHTML = 'Loading airports count...';
        return div;
    };
    totalControl.addTo(map);

    const destinationIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    function setDestination(lat, lng) {
        if (destinationMarker) {
            map.removeLayer(destinationMarker);
        }
        destinationCoordinates = [lat, lng];
        destinationMarker = L.marker(destinationCoordinates, { icon: destinationIcon }).addTo(map);
        destinationMarker.bindPopup("<b>Destination</b>").openPopup();

        if (airportMarkers.getLayers().length > 0) {
            const bounds = airportMarkers.getBounds().extend(destinationCoordinates);
            map.fitBounds(bounds, { padding: [50, 50] });
        } else {
            map.setView(destinationCoordinates, 10);
        }
    }

    function updateRadiusCircle() {
        const radius = parseInt(document.getElementById('radiusRange').value);
        const center = lastClickedAirport ?? map.getCenter();

        if (centerMarker) {
            map.removeLayer(centerMarker);
            centerMarker = null;
        }

        if (radius > 0) {
            centerMarker = L.circle(center, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.3,
                radius: radius * 1000
            }).addTo(map);
        }
    }

    document.getElementById('radiusRange').addEventListener('input', function() {
        document.getElementById('radiusValue').textContent = this.value;
        updateRadiusCircle();
    });

    map.on('click', function(e) {
        lastClickedAirport = { lat: e.latlng.lat, lng: e.latlng.lng };
        updateRadiusCircle();
    });

    async function fetchAndDisplayAirports(filters = {}) {
        airportMarkers.clearLayers();

        const params = new URLSearchParams();
        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => {
                    params.append(`${key}[]`, value);
                });
            } else {
                params.append(key, filters[key]);
            }
        });

        // **Crucial Change:** Send the drawn polygon GeoJSON to the server
        if (drawnPolygonGeoJSON) {
            params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        }

        const response = await fetch(`/api/airports?${params.toString()}`);
        const airports = await response.json();

        // No need for client-side turf.booleanPointInPolygon filtering here
        // as it should be handled by the backend.

        document.querySelector('.total-airports').innerText = `Total Airports: ${airports.length}`;

        if (airports.length === 0) {
            // alert('No airports found with the current filters.'); // Consider a less intrusive message
            // Optionally, clear existing markers to show no results
            airportMarkers.clearLayers();
            return;
        }

        airports.forEach(airport => {
            const airportIcon = L.icon({
                iconUrl: airport.icon || 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
                iconSize: [24, 24],
                iconAnchor: [12, 24],
                popupAnchor: [0, -20]
            });

            const marker = L.marker([airport.latitude, airport.longitude], { icon: airportIcon }).addTo(airportMarkers);

            marker.on('click', () => {
                lastClickedAirport = {
                    lat: airport.latitude,
                    lng: airport.longitude
                };
                updateRadiusCircle();
            });

            marker.bindPopup(`
                <b>${airport.airport_name || 'N/A'}</b><br>
                ${airport.image ? `<img src="${airport.image}" width="200" style="margin: 5px 0;"><br>` : ''}
                <strong>Address:</strong> ${airport.address || 'N/A'}<br>
                <strong>Telephone:</strong> ${airport.telephone || 'N/A'}<br>
                ${airport.website ? `<strong>Website:</strong><a href='${airport.website}' target='__blank'> ${airport.website} </a><br>` : ''}
                ${airport.id ? `<a href="/airports/${airport.id}/detail" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>` : ''}
            `);
        });

        airportMarkers.eachLayer(function(layer) {
            layer.on('popupopen', function() {
                const setDestinationBtn = layer.getPopup().getElement().querySelector('.set-destination-btn');
                if (setDestinationBtn) {
                    setDestinationBtn.addEventListener('click', function() {
                        const lat = parseFloat(this.dataset.lat);
                        const lng = parseFloat(this.dataset.lng);
                        setDestination(lat, lng);
                        map.closePopup();
                    });
                }
            });
        });

        if (airportMarkers.getLayers().length > 0) {
            let bounds = airportMarkers.getBounds();
            if (destinationCoordinates) {
                bounds.extend(destinationCoordinates);
            }
            map.fitBounds(bounds, { padding: [50, 50] });
        } else if (destinationCoordinates) {
            map.setView(destinationCoordinates, 10);
        }
    }

    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    function applyFilters() {
        const name = document.getElementById('name').value;
        const category = document.getElementById('category').value;
        const location = document.getElementById('location').value;
        const radius = parseInt(document.getElementById('radiusRange').value);

        const selectedProvinces = Array.from(document.querySelectorAll('.province-checkbox:checked'))
            .map(checkbox => checkbox.value);

        let filters = {
            name: name,
            category: category,
            location: location,
            provinces: selectedProvinces
        };

        if (radius > 0) {
            const center = lastClickedAirport ?? map.getCenter();
            filters.radius = radius;
            filters.center_lat = center.lat;
            filters.center_lng = center.lng;
        }

        fetchAndDisplayAirports(filters);
        updateRadiusCircle();
    }

    document.getElementById('resetFilter').addEventListener('click', function() {
        document.getElementById('filterForm').reset();
        document.getElementById('radiusValue').textContent = '0';
        document.querySelectorAll('.province-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });

        if (centerMarker) {
            map.removeLayer(centerMarker);
            centerMarker = null;
        }
        if (destinationMarker) {
            map.removeLayer(destinationMarker);
            destinationMarker = null;
            destinationCoordinates = null;
        }

        lastClickedAirport = null;

        // Clear drawn polygon from map and variable
        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null; // Reset the stored GeoJSON

        map.setView([-6.80188562253168, 144.0733101155011], 6);
        fetchAndDisplayAirports();
        updateRadiusCircle();
    });

    document.addEventListener('DOMContentLoaded', () => {
        $(document).ready(function() {
            $('.select2-search').select2({
                placeholder: "🔍 Search...",
                allowClear: true,
                width: '100%',
            });
        });
        fetchAndDisplayAirports();
        updateRadiusCircle();
    });
</script>
@endpush
