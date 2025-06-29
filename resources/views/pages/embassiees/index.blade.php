@extends('layouts.master')

@section('title','Embassiees')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />
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
    .total-embassy {
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
        <h3 style="text-align: center;">Papua New Guinea Embassiees</h3>
    </div>

      <div class="filter-container p-3">
        <form id="filterForm">
            <div class="row g-3 align-items-end">
                 <div class="col-md-4">
                        <label for="name" class="form-label">Embassy Name</label>
                        <select id="name" class="form-select select2-search" name="name">
                            <option value="">🔍 All Embassy</option>
                            @foreach($embassyNames as $name)
                                <option value="{{ $name }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="location" class="form-label">Location</label>
                        <select id="location" class="form-select select2-search" name="location">
                            <option value="">🔍 All Locations</option>
                            @foreach($embassyLocations as $location)
                                <option value="{{ $location }}">{{ $location }}</option>
                            @endforeach
                        </select>
                    </div>

                <div class="col-md-4">
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

                 <div class="col-md-3">
                    <label for="radiusRange" class="form-label">Search in radius <span id="radiusValue">0</span> kilometers</label>
                    <input type="range" id="radiusRange" name="radius" class="form-control" min="0" max="200" value="0">
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
<script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>

<script>

    const map = L.map('map', {
        fullscreenControl: true
    }).setView([-6.80188562253168, 144.0733101155011], 6);

    // --- Define Tile Layers ---
    // 1. OpenStreetMap (Peta Jalan) - Ini akan menjadi default
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    });

    // 2. Esri World Imagery (Peta Satelit) - Pilihan bagus tanpa memerlukan API Key
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19,
    });

    // Tambahkan peta jalan sebagai layer default saat peta pertama kali dimuat
    osmLayer.addTo(map);

    // --- Kontrol Layer untuk beralih jenis peta ---
    // Definisikan base layers yang bisa dipilih pengguna
    const baseLayers = {
        "Street Map": osmLayer,
        "Satelit Map": satelliteLayer
    };

    // Tambahkan kontrol layer ke peta (akan muncul di pojok kanan atas secara default)
    L.control.layers(baseLayers).addTo(map);

    let embassyMarkers = L.featureGroup().addTo(map);
    let centerMarker = null;
    let lastClickedEmbassy = null;
    let destinationMarker = null;
    let destinationCoordinates = null;
    let drawnPolygonGeoJSON = null;

    const drawnItems = new L.FeatureGroup().addTo(map);

    const drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            polyline: false,
            rectangle: false,
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
        const div = L.DomUtil.create('div', 'total-embassy');
        div.innerHTML = 'Loading embassy count...';
        return div;
    };
    totalControl.addTo(map);

    // Fungsi untuk membuat ikon penanda tujuan
    const destinationIcon = L.icon({
        iconUrl: 'https://cdn-icons-png.flaticon.com/512/684/684908.png', // Contoh ikon tujuan (ganti dengan ikon Anda)
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // Fungsi untuk menetapkan dan menampilkan penanda tujuan
    function setDestination(lat, lng) {
        if (destinationMarker) {
            map.removeLayer(destinationMarker); // Hapus marker tujuan yang ada
        }
        destinationCoordinates = [lat, lng];
        destinationMarker = L.marker(destinationCoordinates, { icon: destinationIcon }).addTo(map);
        destinationMarker.bindPopup("<b>Destination</b>").openPopup();

        // Opsional: Sesuaikan tampilan peta untuk menyertakan tujuan
        if (embassyMarkers.getLayers().length > 0) {
            const bounds = embassyMarkers.getBounds().extend(destinationCoordinates);
            map.fitBounds(bounds, { padding: [50, 50] });
        } else {
            map.setView(destinationCoordinates, 10); // Jika tidak ada kedutaan lain, fokus ke tujuan
        }
    }

    // Fungsi untuk memperbarui lingkaran radius
    function updateRadiusCircle() {
        const radius = parseInt(document.getElementById('radiusRange').value);
        const center = lastClickedEmbassy ?? map.getCenter(); // Gunakan kedutaan terakhir diklik, atau pusat peta

        // Pastikan centerMarker dihapus sebelum membuat yang baru, jika ada
        if (centerMarker) {
            map.removeLayer(centerMarker);
            centerMarker = null;
        }

        if (radius > 0) {
            centerMarker = L.circle(center, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.3,
                radius: radius * 1000 // Konversi km ke meter
            }).addTo(map);
        }
    }

    document.getElementById('radiusRange').addEventListener('input', function() {
        document.getElementById('radiusValue').textContent = this.value;
        updateRadiusCircle(); // Panggil fungsi untuk memperbarui lingkaran saat slider digeser
    });

    // Event listener untuk klik pada peta untuk menentukan pusat radius secara manual
    map.on('click', function(e) {
        lastClickedEmbassy = { lat: e.latlng.lat, lng: e.latlng.lng }; // Set pusat radius ke lokasi klik
        updateRadiusCircle(); // Perbarui lingkaran radius
    });

    async function fetchAndDisplayembassy(filters = {}) {
        embassyMarkers.clearLayers();

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

        // **Penting:** Kirim GeoJSON poligon yang digambar ke server
        if (drawnPolygonGeoJSON) {
            params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        }

        const response = await fetch(`/api/embassy?${params.toString()}`);
        const embassy = await response.json();

        document.querySelector('.total-embassy').innerText = `Total embassy: ${embassy.length}`;

        if (embassy.length === 0) {
            embassyMarkers.clearLayers();
            return;
        }

        embassy.forEach(embassy => {
            const embassyIcon = L.icon({
                iconUrl: '/images/embassy-icon-new.png', // Pastikan path ikon ini benar
                iconSize: [24, 24],
                iconAnchor: [12, 24],
                popupAnchor: [0, -20]
            });

            const marker = L.marker([embassy.latitude, embassy.longitude], { icon: embassyIcon }).addTo(embassyMarkers);

            // Simpan kedutaan terakhir yang diklik
            marker.on('click', () => {
                lastClickedEmbassy = {
                    lat: embassy.latitude,
                    lng: embassy.longitude
                };
                updateRadiusCircle(); // Perbarui lingkaran saat marker kedutaan diklik
            });

            // Tambahkan tombol "Set as Destination" ke popup (jika diperlukan)
            // Catatan: Tombol "Set as Destination" di popup tidak ada di HTML Anda
            // Jika Anda ingin ini berfungsi, tambahkan tombol dengan class 'set-destination-btn'
            // dan atribut data-lat, data-lng ke dalam string popup.
            marker.bindPopup(`
                <b>${embassy.name_embassiees || 'N/A'}</b><br>
                ${embassy.image ? `<img src="${embassy.image}" width="200" style="margin: 5px 0;"><br>` : ''}
                <strong>Address:</strong> ${embassy.location || 'N/A'}<br>
                <strong>Telephone:</strong> ${embassy.telephone || 'N/A'}<br>
                ${embassy.website ? `<strong>Website:</strong><a href='${embassy.website}' target='__blank'> ${embassy.website} </a><br>` : ''}
                ${embassy.id ? `<a href="/embassiees/${embassy.id}/detail" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>` : ''}
            `);
        });

        // Event listener untuk tombol "Set as Destination" (setelah semua marker dibuat)
        // Ini akan berfungsi jika Anda menambahkan tombol tersebut di string popup di atas.
        embassyMarkers.eachLayer(function(layer) {
            layer.on('popupopen', function() {
                const setDestinationBtn = layer.getPopup().getElement().querySelector('.set-destination-btn');
                if (setDestinationBtn) {
                    setDestinationBtn.addEventListener('click', function() {
                        const lat = parseFloat(this.dataset.lat);
                        const lng = parseFloat(this.dataset.lng);
                        setDestination(lat, lng);
                        map.closePopup(); // Tutup popup setelah tombol diklik
                    });
                }
            });
        });

        if (embassyMarkers.getLayers().length > 0) {
            let bounds = embassyMarkers.getBounds();
            if (destinationCoordinates) { // Perluas batas jika ada penanda tujuan
                bounds.extend(destinationCoordinates);
            }
            map.fitBounds(bounds, { padding: [50, 50] });
        } else if (destinationCoordinates) { // Jika hanya ada tujuan tanpa kedutaan lain
            map.setView(destinationCoordinates, 10);
        }
    }

    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    function applyFilters() {
        const name = document.getElementById('name').value;
        const location = document.getElementById('location').value;
        const radius = parseInt(document.getElementById('radiusRange').value);

        const selectedProvinces = Array.from(document.querySelectorAll('.province-checkbox:checked'))
            .map(checkbox => checkbox.value);

        let filters = {
            name: name,
            location: location,
            provinces: selectedProvinces
        };

        if (radius > 0) {
            const center = lastClickedEmbassy ?? map.getCenter();
            filters.radius = radius;
            filters.center_lat = center.lat;
            filters.center_lng = center.lng;
        }

        fetchAndDisplayembassy(filters);
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

        lastClickedEmbassy = null;

        // Bersihkan poligon yang digambar dari peta dan variabel
        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null; // Reset GeoJSON yang tersimpan

        map.setView([-6.80188562253168, 144.0733101155011], 6);
        fetchAndDisplayembassy();
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

        fetchAndDisplayembassy();
        updateRadiusCircle(); // Pastikan lingkaran ditampilkan jika ada nilai radius awal
    });
</script>
@endpush
