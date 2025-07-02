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
            <h2 class="fw-bold">{{ $hospital->name }} - Papua New Guinea</h2>
        </div>

        <div class="d-flex gap-2 ms-auto">

            <button onclick="history.back()" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
               <i class="bi bi-arrow-left fs-3"></i>
                <small>Back</small>
            </button>

            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-hospital fs-3"></i>
                <small>Clinical Services</small>
            </a>

            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Air Charter</small>
            </a>

            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <i class="bi bi-bank fs-3"></i>
                <small>Embassies</small>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <small><i>Last Updated</i></small>
             <small><i>{{ $hospital->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-8 d-flex flex-column gap-3">
            <div class="row g-3">
                <div class="col-md-6 d-flex flex-column gap-3">
                    <div class="card h-100">
                        <div class="card-header fw-bold"><i class="fas fa-map-marker-alt"></i> Location</div>
                        <div class="card-body overflow-auto" style="max-height: 350px;">
                               <p>
                                    <strong>Address:</strong>
                                    {{ $hospital->address }},
                                    {{ $province->provinces_region }}, Papua New Guinea
                                </p>
                                <p>
                                    <strong>Latitude:</strong> {{ $hospital->latitude }}
                                </p>
                                <p>
                                    <strong>Longitude:</strong> {{ $hospital->longitude }}
                                </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex flex-column gap-3">
                    <div class="card h-100">
                        <div class="card-header fw-bold"><i class="fas fa-phone"></i> Contact Details</div>
                        <div class="card-body overflow-auto" style="max-height: 350px;">
                            <p>
                                <strong>Telephone:</strong> {{$hospital->telephone}}
                            </p>
                            <p>
                                <strong>Email:</strong> <?php echo $hospital->email; ?>
                            </p>
                            <p>
                                <strong>Website:</strong> <?php echo $hospital->website; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-md-6 d-flex flex-column gap-3">
                    <div class="card h-100">
                        <div class="card-header fw-bold"><i class="fas fa-notes-medical"></i> General Medical Facility Info</div>
                        <div class="card-body overflow-auto" style="max-height: 350px;">
                            <p>
                                <strong>Facility Level:</strong> {{ $hospital->facility_level }}
                            </p>
                            <p>
                                <strong>Status:</strong> {{ $hospital->status }}
                            </p>
                            <p>
                                <strong>Number Of Beds:</strong> {{ $hospital->number_of_beds }} <br>
                            </p>
                            <p>
                                <strong>Population Catchment:</strong> {{ $hospital->population_catchment }}
                            </p>
                            <p>
                                <strong>Ownership:</strong> {{ $hospital->ownership }}
                            </p>
                            <p>
                                <strong>Hours Of Operation:</strong><br>
                                <?php echo $hospital->hrs_of_operation; ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 d-flex flex-column gap-3">
                    <div class="card h-100">
                        <div class="card-header fw-bold"><i class="fas fa-hotel"></i>  Nearest Accommodation</div>
                        <div class="card-body overflow-auto" style="max-height: 350px;">
                           <?php echo $hospital->nearest_accommodation; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header fw-bold"><i class="fas fa-map"></i> Map</div>
                <div class="card-body p-0">
                    <div id="map" style="width: 100%; height: 100%; min-height: 500px;"></div>
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
    const latitude = {{ $hospital->latitude }};
    const longitude = {{ $hospital->longitude }};
    const hospitalName = '{{ $hospital->name }}';

    const map = L.map('map', {
        fullscreenControl: true
    }).setView([latitude, longitude], 16);

    // --- Tile Layers ---
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    });

    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community',
        maxZoom: 19
    });

    satelliteLayer.addTo(map);

    const baseLayers = {
        "Satelit Map": satelliteLayer,
        "Street Map": osmLayer
    };

    L.control.layers(baseLayers).addTo(map);

    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(hospitalName)
        .openPopup();
</script>

@endpush
