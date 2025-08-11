@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Airports')

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

    table{
        width: 100%;
    }

    table tr:nth-child(even) {
        background-color: #ffffff; /* light gray */
    }

    table tr:nth-child(odd) {
        background-color: #c1e4f5; /* white */
    }

    table td{
        text-align: center;
        border-color: #78d9e9;
    }
</style>

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2 align-items-center">
            <h2 class="fw-bold">{{ $airport->airport_name }}</h2>
        </div>

        <div class="d-flex gap-2 ms-auto">

           <button onclick="history.back()" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
               <i class="bi bi-arrow-left fs-3"></i>
                <small>Back</small>
            </button>

              <!-- Button 2 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/detail') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/navigation" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/navigation') ? 'active' : '' }}">
                <i class="bi bi-compass fs-3"></i>
                <small>Navigation</small>
            </a>

             <!-- Button 4 -->
             <a href="{{ url('airports') }}/{{$airport->id}}/airlinesdestination" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/airlinesdestination') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Airlines/Destination</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/emergency" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/emergency') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>

             <!-- Button 5 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                <i class="bi bi-hospital fs-3"></i>
                <small>Medical Facility</small>
            </a>

            <!-- Button 6 -->
            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Air Charter</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <i class="bi bi-bank fs-3"></i>
                <small>Embassies</small>
            </a>

        </div>
</div>

    <div class="card mb-4">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated</i></small>
            <small><i>{{ $airport->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 d-flex flex-column gap-3">
            <div class="card h-100">
             <div class="card-header fw-bold"><i class="fas fa-plane-arrival"></i>Navigation Aids (NAVAIDs)</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <?php echo $airport->navigation_aids; ?>
            </div>
            </div>
        </div>

        <div class="col-md-6 d-flex flex-column gap-3">
            <div class="card h-100">
             <div class="card-header fw-bold"><i class="fas fa-plane-arrival"></i>Navigation Aids for nearby airports</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <?php echo $airport->nearby_airport_navigation_aids; ?>
            </div>
            </div>
        </div>

      <div class="col-md-6 d-flex flex-column gap-3">
            <div class="card h-100">
            <div class="card-header fw-bold"><i class="fas fa-user-shield"></i>Runway Data</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <?php echo $airport->runways; ?>
            </div>
            </div>
        </div>

        <div class="col-md-6 d-flex flex-column gap-3">
            <div class="card h-100">
            <div class="card-header fw-bold"><i class="fas fa-comment"></i>Communication Data</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <?php echo $airport->communication; ?>
            </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')

@endpush
