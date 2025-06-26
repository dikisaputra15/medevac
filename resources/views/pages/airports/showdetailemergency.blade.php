@extends('layouts.master')

@section('title','More Details')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 700px;
    }

    table {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td {
        border: 1px solid black;
        padding: 4px;
    }

     p{
        margin-bottom: 8px;
        line-height: 18px;
    }

     .btn-danger{
        background-color:#395272;
        border-color: transparent;
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

</style>

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2">

            <!-- Button 2 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/navigation" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-compass fs-3"></i>
                <small>Navigation</small>
            </a>

             <!-- Button 4 -->
             <a href="{{ url('airports') }}/{{$airport->id}}/airlinesdestination" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Airlines/Destination</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/emergency" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>

        </div>

        <div class="d-flex gap-2 ms-auto">
            <!-- Button 5 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-hospital fs-3"></i>
                <small>Medical Facilities</small>
            </a>

            <!-- Button 6 -->
            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Air Charter</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
            <i class="bi bi-bank fs-3"></i>
                <small>Embassies</small>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title fw-bold">{{ $airport->airport_name }} - Papua New Guinea <small><i>Last Updated</i></small></h4>
            <small><i>{{ $airport->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card h-100">
                <div class="card-header fw-bold"><i class="fas fa-hospital"></i>Nearest Medical Facility</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <?php echo $airport->nearest_medical_facility; ?>
            </div>
            </div>
        </div>
        <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card h-100">
                <div class="card-header fw-bold"><i class="fas fa-user-shield"></i>Nearest Police Station</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                 <?php echo $airport->nearest_police_station; ?>
            </div>
            </div>
        </div>
        <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card h-100">
                <div class="card-header fw-bold"><i class="fas fa-plane-arrival"></i>Nearest Airports</div>
             <div class="card-body overflow-auto" style="max-height: 300px;">
                <?php echo $airport->nearest_airport; ?>
            </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
        const map = L.map('map').setView([{{ $airport->latitude }}, {{ $airport->longitude }}], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([{{ $airport->latitude }}, {{ $airport->longitude }}]).addTo(map)
            .bindPopup('{{ $airport->airport_name }}').openPopup();
</script>

@endpush
