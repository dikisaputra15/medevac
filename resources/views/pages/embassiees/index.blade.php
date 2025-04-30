@extends('layouts.master')

@section('title','Embassiees')

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
        <h3 style="text-align: center;">Papua New Guinea Embassiees</h3>
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
        const embassieesIcon = L.icon({
            iconUrl: '/images/embassy-icon-new.png', // ganti path ini sesuai lokasi ikon kamu
            iconSize: [24, 24], // ukuran ikon
            iconAnchor: [19, 45], // titik anchor ikon (bagian bawah-tengah)
            popupAnchor: [0, -40] // posisi popup relatif terhadap ikon
        });

        // Buat custom control
        const totalControl = L.control({ position: 'topright' });

        totalControl.onAdd = function (map) {
            const div = L.DomUtil.create('div', 'total-embassiees');
            div.innerHTML = 'Loading embassiees count...';
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

        fetch('/api/embassiees')
            .then(res => res.json())
            .then(data => {
                data.forEach(embassi => {
                    const marker = L.marker([embassi.latitude, embassi.longitude], {icon:embassieesIcon}).addTo(map);
                    marker.bindPopup(`
                        <b>${embassi.name_embassiees}</b><br>
                        <img src="${embassi.image}" width="200" style="margin: 5px 0;"><br>
                        <strong>Address:</strong> ${embassi.location}<br>
                        <strong>Telephone:</strong> ${embassi.telephone}<br>
                        <strong>Website:</strong><a href='${embassi.website}' target='__blank'> ${embassi.website} </a><br>
                        <a href="/embassiees/${embassi.id}/detail" class="btn btn-primary btn-sm" style="color:white;">More Details</a>
                    `);
                });

                document.querySelector('.total-embassiees').innerText = `Total Embassiees: ${data.length}`;

            });

    </script>
@endpush
