@extends('layouts.master')

@section('title','More Details')

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

    <div class="d-flex justify-content-between p-3" style="background-color: #fbeeee;">
        <div class="d-flex gap-2">
            <!-- Button 1 -->
            <a href="{{ url('aircharter') }}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
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

    <div class="card-header bg-white">
        <h3>AIR CHARTER INFORMATION - Papua New Guinea <small><i>Last Updated</i></small></h3>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td></td>
                            <td>CHARTER COMPANY</td>
                            <td colspan="2" style="text-align:center;">AIRCRAFT</td>
                            <td colspan="2" style="text-align:center;">SERVICE</td>
                            <td>OTHER INFO</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><i class="fas fa-building"></i></td>
                            <td><i class="fas fa-plane"></i></td>
                            <td><i class="fas fa-helicopter"></i></td>
                            <td><i class="fas fa-user"></i></td>
                            <td><i class="fas fa-box"></i></td>
                            <td><i class="fas fa-sticky-note"></i></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Name</td>
                            <td>Fixed Wing</td>
                            <td>Rotary</td>
                            <td>Passenger</td>
                            <td>Cargo</td>
                            <td>Notes</td>
                        </tr>

                        @foreach($aircharters as $air)
                            <tr>
                                <td><img src="{{ $air->icon }}" style="width:60px; height:60px;"></td>
                                <td>{{ $air->charter_company_name }}</td>
                                <td>{{ $air->aircraft_fixed_wing }}</td>
                                <td>{{ $air->aircraft_rotary }}</td>
                                <td>{{ $air->service_passenger }}</td>
                                <td>{{ $air->service_cargo }}</td>
                                <td>{{ $air->other_info_notes }}</td>
                            </tr>
                         @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')


@endpush
