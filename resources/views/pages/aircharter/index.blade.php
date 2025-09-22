@extends('layouts.master')

@section('title','More Details')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>

    .btn-danger{
        background-color:#395272;
        border-color: transparent;
    }

    .btn-danger:hover{
        background-color:#5686c3;
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

     .btn-outline-danger:hover{
        background-color:#5686c3;
        border-color: transparent;
    }

    th {
      text-align: center;
      vertical-align: middle;
      font-weight: bold;
    }
    td {
      vertical-align: middle;
    }
    .header-company { background-color: #d6b77d !important; }
    .header-aircraft { background-color: #c1b8ae !important; }
    .header-service { background-color: #c3d1cc !important; }
    .header-weblink  { background-color: #c6c3bd !important; }
    .header-other    { background-color: #b8c7cc !important; }
    .icon { color: #0056d2; font-weight: bold; }

</style>

@endpush

@section('conten')

<div class="card">

     <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2 align-items-center">
            <h2 class="fw-bold">AIR CHARTER INFORMATION - Papua New Guinea </h2>
        </div>

        <div class="d-flex gap-2 ms-auto">
             <!-- Button 5 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
            <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                <small>Embassies</small>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <?php echo $airport->charter_info; ?>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')


@endpush
