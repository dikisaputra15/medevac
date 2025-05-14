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
            <a href="{{ url('airports') }}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

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

    <div class="card-header bg-white">
        <h3>{{ $airport->airport_name }}</h3>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-globe"></i><b>International</b></h2>
                <table class="table">
                    <tr>
                        <td>Country</td>
                        <td>Destination City</td>
                        <td>Airline</td>
                    </tr>
                    @foreach($internationals as $inter)
                        <tr>
                            <td>{{ $inter->country }}</td>
                            <td>{{ $inter->destination_city }}</td>
                            <td>{{ $inter->airlines }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-plane"></i><b>Domestic</b></h2>
                <table class="table">
                    <tr>
                        <td>Destination Airport</td>
                        <td>Airline</td>
                    </tr>
                    @foreach($domestics as $dom)
                        <tr>
                            <td>{{ $dom->destination_airport }}</td>
                            <td>{{ $dom->airlines }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-plane-arrival"></i><b>Flight Information</b></h2>
                @php
                    $flight = $airport->flight_information;
                    $flightexp = explode(', ', $flight);
                @endphp

                    <ul>
                        @foreach ($flightexp as $fli)
                            <li><a href="{{ $fli }}">{{ $fli }}</a></li>
                        @endforeach
                    </ul>
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
