@extends('layouts.master')

@section('title','Hospitals')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        const map = L.map('map').setView([-6.80188562253168, 144.0733101155011], 6);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        let hospitalMarkers = L.featureGroup().addTo(map);
        let centerMarker = null; // Ini adalah variabel yang harus Anda modifikasi
        let lastClickedhospital = null; // Menyimpan koordinat bandara yang terakhir diklik
        let destinationMarker = null; // Tambahkan variabel untuk marker tujuan
        let destinationCoordinates = null; // Tambahkan variabel untuk menyimpan koordinat tujuan

        const totalControl = L.control({ position: 'topright' });
            totalControl.onAdd = function (map) {
        const div = L.DomUtil.create('div', 'total-hospital');
            div.innerHTML = 'Loading hospital count...';
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
                if (hospitalMarkers.getLayers().length > 0) {
                    const bounds = hospitalMarkers.getBounds().extend(destinationCoordinates);
                    map.fitBounds(bounds, { padding: [50, 50] });
                } else {
                    map.setView(destinationCoordinates, 10); // Jika tidak ada bandara lain, fokus ke tujuan
                }
            }


            // Fungsi untuk memperbarui lingkaran radius
            function updateRadiusCircle() {
                const radius = parseInt(document.getElementById('radiusRange').value);
                const center = lastClickedhospital ?? map.getCenter(); // Gunakan bandara terakhir diklik, atau pusat peta

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
                lastClickedhospital = { lat: e.latlng.lat, lng: e.latlng.lng }; // Set pusat radius ke lokasi klik
                updateRadiusCircle(); // Perbarui lingkaran radius
            });

        async function fetchAndDisplayhospital(filters = {}) {
        hospitalMarkers.clearLayers();
        // centerMarker tidak perlu dihapus di sini, karena updateRadiusCircle() akan menanganinya
        // atau akan dihapus jika radius 0 saat filterForm disubmit atau reset.

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

        const response = await fetch(`/api/hospital?${params.toString()}`);
        const hospital = await response.json();

        document.querySelector('.total-hospital').innerText = `Total hospital: ${hospital.length}`;

        if (hospital.length === 0) {
            alert('No hospital found with the current filters.');
            return;
        }

        hospital.forEach(hospital => {
            const hospitalIcon = L.icon({
            iconUrl: hospital.icon || 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
            iconSize: [24, 24],
            iconAnchor: [12, 24],
            popupAnchor: [0, -20]
         });

         const marker = L.marker([hospital.latitude, hospital.longitude], { icon: hospitalIcon }).addTo(hospitalMarkers);

         // Simpan hospital terakhir yang diklik
         marker.on('click', () => {
            lastClickedhospital = {
            lat: hospital.latitude,
            lng: hospital.longitude
         };
                        updateRadiusCircle(); // Perbarui lingkaran saat marker bandara diklik
        });

                    // Tambahkan tombol "Set as Destination" ke popup
                    marker.bindPopup(`
                        <b>${hospital.name || 'N/A'}</b><br>
                        ${hospital.image ? `<img src="${hospital.image}" width="200" style="margin: 5px 0;"><br>` : ''}
                        <strong>Location:</strong> ${hospital.address || 'N/A'}<br>
                        <strong>Coords:</strong> ${hospital.latitude}, ${hospital.longitude}<br>
                        <strong>Region:</strong> ${hospital.region || 'N/A'}<br>
                        <strong>Level:</strong> ${hospital.facility_level || 'N/A'}<br>
                        ${hospital.id ? `<a href="/hospitals/${hospital.id}" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>` : ''}

                    `);
            });

                // Event listener untuk tombol "Set as Destination" (setelah semua marker dibuat)
                hospitalMarkers.eachLayer(function(layer) {
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

                if (hospitalMarkers.getLayers().length > 0) {
                let bounds = hospitalMarkers.getBounds();
                    if (destinationCoordinates) { // Perluas batas jika ada penanda tujuan
                        bounds.extend(destinationCoordinates);
                    }
                    map.fitBounds(bounds, { padding: [50, 50] });
                 } else if (destinationCoordinates) { // Jika hanya ada tujuan tanpa bandara lain
                    map.setView(destinationCoordinates, 10);
                }
             }

            document.getElementById('filterForm').addEventListener('submit', async function(e) {
            e.preventDefault();

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

                // Ketika form disubmit, pusat radius akan menjadi pusat peta saat ini (jika tidak ada bandara yang diklik)
                // atau bandara terakhir yang diklik. updateRadiusCircle() akan menanganinya.
                // Tidak perlu lagi blok if/else radius di sini karena updateRadiusCircle() sudah mengelola logika itu.
                // Anda hanya perlu memastikan filter radius terkirim ke backend.
                if (radius > 0) {
                    const center = lastClickedhospital ?? map.getCenter();
                    filters.radius = radius;
                    filters.center_lat = center.lat;
                    filters.center_lng = center.lng;
                }

        await fetchAndDisplayhospital(filters);
                updateRadiusCircle(); // Panggil fungsi untuk memperbarui lingkaran setelah fetch data selesai
         });

         document.getElementById('resetFilter').addEventListener('click', async function() {
         document.getElementById('filterForm').reset();
         document.getElementById('radiusValue').textContent = '0';
         document.querySelectorAll('.province-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Pastikan centerMarker dan destinationMarker dihapus
            if (centerMarker) {
                 map.removeLayer(centerMarker);
                    centerMarker = null;
             }
                if (destinationMarker) {
                    map.removeLayer(destinationMarker);
                    destinationMarker = null;
                    destinationCoordinates = null;
                }

            lastClickedhospital = null; // Reset pusat radius juga
                 map.setView([-6.80188562253168, 144.0733101155011], 6);
                 await fetchAndDisplayhospital();
                updateRadiusCircle(); // Panggil ini untuk memastikan lingkaran hilang (karena radius 0)
             });

         document.addEventListener('DOMContentLoaded', () => {
            $(document).ready(function() {
                $('.select2-search').select2({
                    placeholder: "🔍 Search...",
                    allowClear: true,
                    width: '100%',
                });
            });

            fetchAndDisplayhospital();
            updateRadiusCircle(); // Pastikan lingkaran ditampilkan jika ada nilai radius awal
        });
    </script>
@endpush
