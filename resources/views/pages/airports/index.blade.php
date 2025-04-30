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

    <div id="map"></div>

</div>


@endsection

@push('service')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
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

    </script>
@endpush
