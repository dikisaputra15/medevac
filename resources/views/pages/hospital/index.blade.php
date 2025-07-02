@extends('layouts.master')

@section('title','Hospitals')

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
    .total-hospital {
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
        <h3 style="text-align: center;">Papua New Guinea Hospital</h3>
    </div>

    <div class="filter-container p-3">
        <form id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="name" class="form-label">Hospital Name</label>
                    <select id="name" class="form-select select2-search" name="name">
                        <option value="">🔍 All Hospital</option>
                        @foreach($hospitalNames as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="category" class="form-label">Facility Level</label>
                    <select id="category" class="form-select select2-search" name="category">
                        <option value="">🔍 All Facility Level</option>
                        @foreach($hospitalCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="location" class="form-label">Location</label>
                    <select id="location" class="form-select select2-search" name="location">
                        <option value="">🔍 All Locations</option>
                        @foreach($hospitalLocations as $location)
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
<script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>

<script>
    // Inisialisasi peta Leaflet
    const map = L.map('map', {
        fullscreenControl: true
    }).setView([-6.80188562253168, 144.0733101155011], 6); // Set view ke zoom level yang lebih luas

    // --- Define Tile Layers ---
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    });

    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19,
    });

    osmLayer.addTo(map); // Default to Street Map

    const baseLayers = {
        "Satelit Map": satelliteLayer,
        "Street Map": osmLayer
    };

    L.control.layers(baseLayers).addTo(map);

    let hospitalMarkers = L.featureGroup().addTo(map);
    let centerRadiusCircle = null; // Ganti nama variabel dari centerMarker ke centerRadiusCircle agar lebih jelas
    let lastClickedMapCenter = null; // Menyimpan koordinat terakhir diklik di peta atau rumah sakit
    let destinationMarker = null;
    let destinationCoordinates = null;
    let drawnPolygonGeoJSON = null; // Menyimpan GeoJSON dari poligon yang digambar

    // FeatureGroup untuk lapisan yang digambar
    const drawnItems = new L.FeatureGroup().addTo(map);
    map.addLayer(drawnItems);

    // Kontrol Draw untuk menggambar poligon
    const drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false, // Disallow intersecting polygons
                shapeOptions: {
                    color: '#346abb' // Warna garis poligon
                },
                showArea: true // Tampilkan luas area
            },
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

    // Event listener untuk saat poligon selesai digambar
    map.on(L.Draw.Event.CREATED, function (event) {
        const layer = event.layer;
        drawnItems.clearLayers(); // Hapus poligon sebelumnya jika ada
        drawnItems.addLayer(layer);
        drawnPolygonGeoJSON = layer.toGeoJSON(); // Simpan GeoJSON poligon yang baru
        applyFilters(); // Terapkan filter setelah menggambar
    });

    // Event listener untuk saat poligon diedit
    map.on(L.Draw.Event.EDITED, function (event) {
        const layers = event.layers;
        layers.eachLayer(function (layer) {
            drawnPolygonGeoJSON = layer.toGeoJSON(); // Perbarui GeoJSON poligon yang diedit
        });
        applyFilters(); // Terapkan filter setelah mengedit
    });

    // Event listener untuk saat poligon dihapus
    map.on(L.Draw.Event.DELETED, function (event) {
        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null; // Hapus GeoJSON poligon
        applyFilters(); // Terapkan filter setelah menghapus
    });

    // Kontrol untuk menampilkan total rumah sakit
    const totalControl = L.control({ position: 'topright' });
    totalControl.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'total-hospital');
        div.innerHTML = 'Loading hospital count...';
        return div;
    };
    totalControl.addTo(map);

    // Icon untuk destinasi (jika ada)
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

        // Sesuaikan tampilan peta untuk mencakup destinasi dan rumah sakit jika ada
        if (hospitalMarkers.getLayers().length > 0) {
            const bounds = hospitalMarkers.getBounds().extend(destinationCoordinates);
            map.fitBounds(bounds, { padding: [50, 50] });
        } else {
            map.setView(destinationCoordinates, 10);
        }
    }

    // Fungsi untuk memperbarui lingkaran radius
    function updateRadiusCircle() {
        const radius = parseInt(document.getElementById('radiusRange').value);
        // Tentukan pusat radius: jika ada klik terakhir, gunakan itu. Jika tidak, gunakan pusat peta saat ini.
        const center = lastClickedMapCenter || map.getCenter();

        if (centerRadiusCircle) {
            map.removeLayer(centerRadiusCircle);
            centerRadiusCircle = null;
        }

        if (radius > 0) {
            centerRadiusCircle = L.circle(center, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.3,
                radius: radius * 1000 // radius dalam meter
            }).addTo(map);
        }
    }

    // Event listener untuk perubahan nilai radius
    document.getElementById('radiusRange').addEventListener('input', function() {
        document.getElementById('radiusValue').textContent = this.value;
        updateRadiusCircle(); // Perbarui lingkaran radius secara visual
        applyFilters(); // Terapkan filter saat radius berubah
    });

    // Event listener untuk klik peta: menentukan pusat untuk radius jika belum ada
    map.on('click', function(e) {
        lastClickedMapCenter = { lat: e.latlng.lat, lng: e.latlng.lng };
        updateRadiusCircle(); // Perbarui lingkaran radius
    });

    // Fungsi utama untuk mengambil dan menampilkan data rumah sakit
    async function fetchAndDisplayHospital(filters = {}) {
        hospitalMarkers.clearLayers(); // Hapus marker yang ada

        const params = new URLSearchParams();
        // Tambahkan filter ke parameter URL
        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => {
                    params.append(`${key}[]`, value);
                });
            } else if (filters[key] !== null && filters[key] !== undefined && filters[key] !== '') {
                params.append(key, filters[key]);
            }
        });

        // Tambahkan data GeoJSON poligon jika ada
        if (drawnPolygonGeoJSON) {
            params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        }

        // --- Simpan parameter filter ke localStorage untuk persistensi ---
        localStorage.setItem('hospitalFilterParams', params.toString());
        if (drawnPolygonGeoJSON) {
            localStorage.setItem('hospitalDrawnPolygon', JSON.stringify(drawnPolygonGeoJSON));
        } else {
            localStorage.removeItem('hospitalDrawnPolygon');
        }
        if (lastClickedMapCenter) {
            localStorage.setItem('hospitalLastClickedCenter', JSON.stringify(lastClickedMapCenter));
        } else {
            localStorage.removeItem('hospitalLastClickedCenter');
        }

        try {
            const response = await fetch(`/api/hospital?${params.toString()}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            const hospitalData = await response.json(); // Ubah nama variabel untuk menghindari konflik

            document.querySelector('.total-hospital').innerText = `Total hospital: ${hospitalData.length}`;

            if (hospitalData.length === 0) {
                hospitalMarkers.clearLayers();
                // Opsional: Tampilkan pesan "Tidak ada rumah sakit yang ditemukan" di UI
                return;
            }

            hospitalData.forEach(hospital => {
                const hospitalIcon = L.icon({
                    iconUrl: hospital.icon || 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
                    iconSize: [24, 24],
                    iconAnchor: [12, 24],
                    popupAnchor: [0, -20]
                });

                const marker = L.marker([hospital.latitude, hospital.longitude], { icon: hospitalIcon }).addTo(hospitalMarkers);

                // Ketika marker rumah sakit diklik, perbarui pusat radius
                marker.on('click', () => {
                    lastClickedMapCenter = {
                        lat: hospital.latitude,
                        lng: hospital.longitude
                    };
                    updateRadiusCircle(); // Perbarui lingkaran radius
                });

                marker.bindPopup(`
                    <b>${hospital.name || 'N/A'}</b><br>
                    ${hospital.image ? `<img src="${hospital.image}" width="200" style="margin: 5px 0;"><br>` : ''}
                    <strong>Location:</strong> ${hospital.address || 'N/A'}<br>
                    <strong>Coords:</strong> ${hospital.latitude}, ${hospital.longitude}<br>
                    <strong>Province:</strong> ${hospital.provinces_region || 'N/A'}<br>
                    <strong>Level:</strong> ${hospital.facility_level || 'N/A'}<br>
                    ${hospital.id ? `<a href="/hospitals/${hospital.id}" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>` : ''}
                `);
            });

            // Sesuaikan tampilan peta agar sesuai dengan semua marker rumah sakit
            if (hospitalMarkers.getLayers().length > 0) {
                let bounds = hospitalMarkers.getBounds();
                if (destinationCoordinates) {
                    bounds.extend(destinationCoordinates);
                }
                map.fitBounds(bounds, { padding: [50, 50] });
            } else if (destinationCoordinates) {
                map.setView(destinationCoordinates, 10);
            }

        } catch (error) {
            console.error('Error fetching hospital data:', error);
            document.querySelector('.total-hospital').innerText = 'Error loading hospitals.';
        }
    }

    // Fungsi untuk mengumpulkan dan menerapkan semua filter
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

        // Jika radius lebih dari 0, tambahkan parameter radius dan pusatnya
        if (radius > 0) {
            // Gunakan lastClickedMapCenter, jika tidak ada, gunakan pusat peta saat ini
            const center = lastClickedMapCenter || map.getCenter();
            filters.radius = radius;
            filters.center_lat = center.lat;
            filters.center_lng = center.lng;
        }

        fetchAndDisplayHospital(filters);
    }

    // Fungsi untuk memuat filter dari localStorage dan menerapkannya
    function loadFiltersAndApply() {
        const savedParamsString = localStorage.getItem('hospitalFilterParams');
        const savedPolygonString = localStorage.getItem('hospitalDrawnPolygon');
        const savedCenterString = localStorage.getItem('hospitalLastClickedCenter');

        // Pastikan Select2 sudah diinisialisasi sebelum mencoba mengatur nilainya
        $('.select2-search').select2({
            placeholder: "🔍 Search...",
            allowClear: true,
            width: '100%',
        });

        if (savedParamsString) {
            const params = new URLSearchParams(savedParamsString);

            // Isi kembali form fields
            document.getElementById('name').value = params.get('name') || '';
            document.getElementById('category').value = params.get('category') || '';
            document.getElementById('location').value = params.get('location') || '';

            // Tangani radius
            const savedRadius = parseInt(params.get('radius')) || 0;
            document.getElementById('radiusRange').value = savedRadius;
            document.getElementById('radiusValue').textContent = savedRadius;

            // Tangani checkboxes provinsi
            const savedProvinces = params.getAll('provinces[]');
            document.querySelectorAll('.province-checkbox').forEach(checkbox => {
                checkbox.checked = savedProvinces.includes(checkbox.value);
            });

            // Pulihkan pilihan Select2
            $('#name').val(params.get('name')).trigger('change');
            $('#category').val(params.get('category')).trigger('change');
            $('#location').val(params.get('location')).trigger('change');

            // Pulihkan lastClickedMapCenter untuk lingkaran radius jika tersedia
            if (savedCenterString) {
                lastClickedMapCenter = JSON.parse(savedCenterString);
            }

            // Pulihkan poligon yang digambar
            if (savedPolygonString) {
                drawnPolygonGeoJSON = JSON.parse(savedPolygonString);
                // Penting: pastikan GeoJSON adalah tipe yang valid sebelum ditambahkan
                if (drawnPolygonGeoJSON && drawnPolygonGeoJSON.geometry && drawnPolygonGeoJSON.geometry.coordinates) {
                    const layer = L.geoJSON(drawnPolygonGeoJSON);
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);

                    // Sesuaikan peta ke poligon yang digambar
                    map.fitBounds(layer.getBounds(), { padding: [50, 50] });
                }
            }

            // Terapkan filter untuk mengambil data
            applyFilters();
            updateRadiusCircle(); // Pastikan lingkaran radius diperbarui setelah semua data dimuat
        } else {
            // Jika tidak ada filter yang disimpan, ambil data awal (tanpa filter)
            fetchAndDisplayHospital();
        }
    }


    // Event listener untuk submit form filter
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    // Event listener untuk tombol reset filter
    document.getElementById('resetFilter').addEventListener('click', function() {
        document.getElementById('filterForm').reset();
        document.getElementById('radiusValue').textContent = '0';
        document.querySelectorAll('.province-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Reset Select2
        $('.select2-search').val(null).trigger('change');

        if (centerRadiusCircle) {
            map.removeLayer(centerRadiusCircle);
            centerRadiusCircle = null;
        }
        if (destinationMarker) {
            map.removeLayer(destinationMarker);
            destinationMarker = null;
            destinationCoordinates = null;
        }

        lastClickedMapCenter = null; // Reset pusat klik terakhir

        drawnItems.clearLayers(); // Hapus lapisan yang digambar
        drawnPolygonGeoJSON = null; // Hapus data GeoJSON poligon

        // Hapus filter yang disimpan dari localStorage
        localStorage.removeItem('hospitalFilterParams');
        localStorage.removeItem('hospitalDrawnPolygon');
        localStorage.removeItem('hospitalLastClickedCenter');

        map.setView([-6.80188562253168, 144.0733101155011], 6); // Set ulang tampilan peta
        fetchAndDisplayHospital(); // Ambil data tanpa filter
        updateRadiusCircle(); // Perbarui lingkaran radius (seharusnya hilang)
    });

    // Inisialisasi Select2 dan muat filter saat DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        loadFiltersAndApply();
    });
</script>

@endpush
