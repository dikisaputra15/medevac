@extends('layouts.master')

@section('title','Hospitals')

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
        <h3 style="text-align: center;">Papua New Guinea Hospital</h3>
    </div>

    <div id="map"></div>

</div>


@endsection

@push('service')
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-6.80188562253168, 144.0733101155011], 6);

        // icon custom
        const hospitalIcon = L.icon({
            iconUrl: '/images/hospital-icon.png', // ganti path ini sesuai lokasi ikon kamu
            iconSize: [24, 24], // ukuran ikon
            iconAnchor: [19, 45], // titik anchor ikon (bagian bawah-tengah)
            popupAnchor: [0, -40] // posisi popup relatif terhadap ikon
        });

        // Buat custom control
        const totalControl = L.control({ position: 'topright' });

        totalControl.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'total-hospitals');
            div.innerHTML = 'Loading hospital count...';
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

        fetch('/api/hospitals')
            .then(res => res.json())
            .then(data => {
                data.forEach(hospital => {
                    const marker = L.marker([hospital.latitude, hospital.longitude], {icon:hospitalIcon}).addTo(map);
                    marker.bindPopup(`
                        <b>${hospital.name}</b><br>
                        <img src="${hospital.image}" width="200" style="margin: 5px 0;"><br>
                        <strong>Location:</strong> ${hospital.address}<br>
                        <strong>Coords:</strong> ${hospital.latitude}, ${hospital.longitude}<br>
                        <strong>Region:</strong> ${hospital.region}<br>
                        <strong>Level:</strong> ${hospital.facility_level}<br>
                        <a href="/hospitals/${hospital.id}" class="btn btn-primary btn-sm" style="color:white;">More Details</a>
                    `);
                });

                document.querySelector('.total-hospitals').innerText = `Total Hospitals: ${data.length}`;

            });

    </script>
@endpush
