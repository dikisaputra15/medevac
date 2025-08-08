@extends('layouts.master')

@section('title','More Details')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />
<style>
    #map {
        height: 700px;
    }

     p{
        margin-bottom: 8px;
        line-height: 18px;
    }

     .btn-danger{
        background-color:#395272;
        border-color: transparent;
    }

    .btn-danger:hover{
        background-color:#5686c3;
        border-color: transparent;
    }

    .btn.active {
        background-color: #5686c3 !important;
        border-color: transparent !important;
        color: #fff !important;
    }

    .p-3{
        padding: 10px !important;
        margin: 0 3px;
    }

    .btn-outline-danger{
        color: #FFFFFF;
        background-color:#395272;
        border-color: transparent;
    }

     .btn-outline-danger:hover{
        background-color:#5686c3;
        border-color: transparent;
    }

    .fa,
    .fab,
    .fad,
    .fal,
    .far,
    .fas {
        color: #346abb;
    }
</style>

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2 align-items-center">
            <h2 class="fw-bold">{{ $embassy->name_embassiees }} - Papua New Guinea</h2>
        </div>

        <div class="d-flex gap-2 ms-auto">

            <button onclick="history.back()" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
               <i class="bi bi-arrow-left fs-3"></i>
                <small>Back</small>
            </button>
            <!-- Button 2 -->
            <a href="{{ url('embassiees') }}/{{$embassy->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees/'.$embassy->id.'/detail') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Air Charter</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
            <i class="bi bi-hospital fs-3"></i>
                <small>Medical Facility</small>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <small><i>Last Updated</i></small>
            <small><i>{{ $embassy->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-phone"></i> Contact Information</div>
                <div class="card-body">
                <p>
                    <strong>Telephone:</strong> {{ $embassy->telephone ?? '-' }}
                </p>
                <p>
                    <strong>Fax:</strong> {{ $embassy->fax ?? '-' }}
                </p>
                    <strong>Email:</strong> {{ $embassy->email ?? '-' }}
                </p>
                <p>
                    <strong>Website:</strong> <a href="{{ $embassy->website }}" target="_blank">{{ $embassy->website }}</a>
                </p>
                <p>
                    <strong>Latitude:</strong> {{ $embassy->latitude ?? '-' }}
                </p>
                <p>
                    <strong>Longitude:</strong> {{ $embassy->longitude ?? '-' }}
                </p>
                 <p>
                    <strong>Location:</strong> {{ $embassy->location ?? '-' }}
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                 <div class="card-header fw-bold"><i class="fas fa-map"></i> Map</div>
                  <div class="card-body">
                <div id="map" style="height: 300px;"></div>
            </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>
<script>
    const latitude = {{ $embassy->latitude }};
    const longitude = {{ $embassy->longitude }};
    const embassyName = '{{ $embassy->name_embassiees }}'; // Using the embassy name from your data

    const map = L.map('map', {
        fullscreenControl: true
    }).setView([latitude, longitude], 16);

    // --- Define Tile Layers ---
    // 1. Street Map (OpenStreetMap)
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19 // OSM generally goes up to zoom level 19
    });

    // 2. Satellite Map (Esri World Imagery) - Recommended, no API key needed
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19 // Esri World Imagery also typically goes up to zoom level 19
    });

    // Add the satellite layer to the map by default
    satelliteLayer.addTo(map);

    // --- Add Layer Control ---
    // Define the base layers that the user can switch between
   const baseLayers = {
        "Satelit Map": satelliteLayer,
        "Street Map": osmLayer
    };

    // Add the layer control to the map. This will appear in the top-right corner.
    L.control.layers(baseLayers).addTo(map);

    // Add a marker at the embassy's location
    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(embassyName) // Display the embassy's name when the marker is clicked
        .openPopup(); // Automatically open the popup when the map loads
</script>

@endpush
