@extends('layouts.master')

@section('title','Airports')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 700px;
    }
</style>

@endpush

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3 style="text-align: center;">Papua New Guinea Airports</h3>
    </div>

    <form id="filterForm" class="p-3">
        <div class="row">
            <div class="col-md-4">
                <input type="text" id="name" class="form-control" placeholder="Airport Name">
            </div>
            <div class="col-md-4">
                <input type="text" id="category" class="form-control" placeholder="Category">
            </div>
            <div class="col-md-4">
                <input type="text" id="location" class="form-control" placeholder="Location">
            </div>
           <div class="col-md-6">
                <label for="radiusRange">Search in radius <span id="radiusValue">0</span> kilometers</label>
                <input type="range" id="radiusRange" name="radius" class="form-range" min="0" max="200" value="1" style="width: 100%; accent-color: darkred;">
            </div>

            <div class="col-md-6">
                <label><strong>Provinces Region</strong></label>
                <div class="form-check" style="max-height: 150px; overflow-y: auto; border: 1px solid #ddd; border-radius: 5px;">
                    @foreach ($provinces as $province)
                        <div>
                            <input class="form-check-input province-checkbox" type="checkbox" name="provinces[]" value="{{ $province->id }}" id="province_{{ $province->id }}">
                            <label class="form-check-label" for="province_{{ $province->id }}">
                                {{ $province->provinces_region }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-md-">
                <button type="submit" class="btn btn-primary btn-block">Filter</button>
            </div>
        </div>
    </form>


    <div id="map"></div>

</div>


@endsection

@push('service')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- <script>
        const radiusSlider = document.getElementById('radiusRange');
        const radiusDisplay = document.getElementById('radiusValue');

        radiusSlider.addEventListener('input', function () {
            radiusDisplay.innerText = this.value;
        });
    </script> -->

    <!-- <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-6.80188562253168, 144.0733101155011], 6);

        // Buat custom control
        const totalControl = L.control({ position: 'topright' });

        totalControl.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'total-airports');
            div.innerHTML = 'Loading airports count...';
            div.style.background = 'white';
            div.style.padding = '8px 12px';
            div.style.borderRadius = '8px';
            div.style.boxShadow = '0 0 6px rgba(0,0,0,0.2)';
            div.style.fontWeight = 'bold';
            return div;
        };

        totalControl.addTo(map);


        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        fetch('/api/airports')
            .then(res => res.json())
            .then(data => {
                data.forEach(airport => {

                      // icon custom
                    const airportIcon = L.icon({
                        iconUrl: airport.icon, // ganti path ini sesuai lokasi ikon kamu
                        iconSize: [24, 24], // ukuran ikon
                        iconAnchor: [19, 45], // titik anchor ikon (bagian bawah-tengah)
                        popupAnchor: [0, -40] // posisi popup relatif terhadap ikon
                    });

                    const marker = L.marker([airport.latitude, airport.longitude], {icon:airportIcon}).addTo(map);
                    marker.bindPopup(`
                        <b>${airport.airport_name}</b><br>
                        <img src="${airport.image}" width="200" style="margin: 5px 0;"><br>
                        <strong>Address:</strong> ${airport.address}<br>
                        <strong>Telephone:</strong> ${airport.telephone}<br>
                        <strong>Website:</strong><a href='${airport.website}' target='__blank'> ${airport.website} </a><br>
                        <a href="/airports/${airport.id}/detail" class="btn btn-primary btn-sm" style="color:white;">More Details</a>
                    `);
                });

                document.querySelector('.total-airports').innerText = `Total Airports: ${data.length}`;

            });

    </script> -->

     <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-6.80188562253168, 144.0733101155011], 6);
        let markers = []; // Array untuk menyimpan marker

        // Buat custom control untuk total bandara
        const totalControl = L.control({ position: 'topright' });
        totalControl.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'total-airports');
            div.innerHTML = 'Loading airports count...';
            div.style.background = 'white';
            div.style.padding = '8px 12px';
            div.style.borderRadius = '8px';
            div.style.boxShadow = '0 0 6px rgba(0,0,0,0.2)';
            div.style.fontWeight = 'bold';
            return div;
        };
        totalControl.addTo(map);

        // Tambahkan layer peta
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        // Fungsi untuk menghapus semua marker dari peta
        function clearMarkers() {
            markers.forEach(marker => map.removeLayer(marker));
            markers = [];
        }

        // Fungsi untuk memuat data bandara berdasarkan filter
        function loadAirports(filters = {}) {
            const query = new URLSearchParams();
            if (filters.name) query.append('name', filters.name);
            if (filters.category) query.append('category', filters.category);
            if (filters.location) query.append('location', filters.location);
            if (filters.radius) query.append('radius', filters.radius);
            if (filters.provinces) {
                filters.provinces.forEach(province => query.append('provinces[]', province));
            }

            fetch(`/api/airports?${query.toString()}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
                .then(res => res.json())
                .then(data => {
                    clearMarkers();

                    data.forEach(airport => {
                        const airportIcon = L.icon({
                            iconUrl: airport.icon || '/images/default-airport-icon.png',
                            iconSize: [24, 24],
                            iconAnchor: [19, 45],
                            popupAnchor: [0, -40]
                        });

                        const marker = L.marker([airport.latitude, airport.longitude], { icon: airportIcon }).addTo(map);
                        marker.bindPopup(`
                            <b>${airport.airport_name}</b><br>
                            <img src="${airport.image || '/images/default-airport.jpg'}" width="200" style="margin: 5px 0;"><br>
                            <strong>Address:</strong> ${airport.address}<br>
                            <strong>Telephone:</strong> ${airport.telephone || 'N/A'}<br>
                            <strong>Website:</strong> <a href="${airport.website || '#'}" target="_blank">${airport.website || 'N/A'}</a><br>
                            <a href="/airports/${airport.id}/detail" class="btn btn-primary btn-sm" style="color:white;">More Details</a>
                        `);
                        markers.push(marker);
                    });

                    document.querySelector('.total-airports').innerText = `Total Airports: ${data.length}`;
                })
                .catch(error => {
                    console.error('Error fetching airports:', error);
                    document.querySelector('.total-airports').innerText = 'Error loading airports';
                });
        }

        // Panggil loadAirports saat halaman dimuat
        loadAirports();

        // Tangani submit form filter
        document.getElementById('filterForm').addEventListener('submit', function (e) {
            e.preventDefault();

            // Kumpulkan nilai filter
            const filters = {
                name: document.getElementById('name').value.trim(),
                category: document.getElementById('category').value.trim(),
                location: document.getElementById('location').value.trim(),
                radius: document.getElementById('radiusRange').value,
                provinces: Array.from(document.querySelectorAll('.province-checkbox:checked'))
                    .map(checkbox => checkbox.value)
            };

            // Panggil fungsi loadAirports dengan filter
            loadAirports(filters);
        });

        // Update nilai radius secara real-time
        const radiusSlider = document.getElementById('radiusRange');
        const radiusDisplay = document.getElementById('radiusValue');
        radiusSlider.addEventListener('input', function () {
            radiusDisplay.innerText = this.value;
        });
    </script>
@endpush
