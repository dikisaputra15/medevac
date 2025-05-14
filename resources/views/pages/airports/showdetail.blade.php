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
        <h3>{{ $airport->airport_name }} - Papua New Guinea <small><i>Last Updated</i></small></h3>
        <small><i>{{ $airport->created_at->format('M Y') }}</i></small>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5>📍 Location</h5>
                <p>
                    <strong>Address:</strong>
                    {{ $airport->address }}, Papua New Guinea
                </p>
                <p>
                    <strong>Latitude:</strong> {{ $airport->latitude }}<br>
                    <strong>Longitude:</strong> {{ $airport->longitude }}
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5>📞 Contact Details</h5>
                <p>
                    <strong>Telephone:</strong> {{ $airport->email ?? '-' }}<br>
                    <strong>Fax:</strong> {{ $airport->fax ?? '-' }}<br>
                    <strong>Email:</strong> {{ $airport->email ?? '-' }}<br>
                    <strong>Website:</strong>
                    <a href="{{ $airport->website }}" target="_blank">{{ $airport->website }}</a>
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5>🗺️ Map</h5>
                <div id="map" style="height: 300px;"></div>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">🏥 General Airport Info</h5><br>
                <p>
                    <strong>Category:</strong> {{ $airport->category }} <br>
                    <strong>Classification:</strong> {{ $airport->classification }} <br>
                    <strong>IATA Code:</strong> {{ $airport->iata_code }} <br>
                    <strong>ICAO Code:</strong> {{ $airport->icao_code }} <br>
                    <strong>Hrs of operation:</strong> {{ $airport->hrs_of_operation }} <br>
                </p>
                @php
                    $distance = $airport->distance_from;
                    $distanceexp = explode(', ', $distance);
                @endphp

                    <ul>
                        @foreach ($distanceexp as $dist)
                            <li>{{ $dist }}</li>
                        @endforeach
                    </ul>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <p>
                    <strong>Time Zone:</strong> {{ $airport->time_zone }} <br>
                    <strong>Operator:</strong> {{ $airport->operator }} <br>
                    <strong>Magnetic Variation:</strong> {{ $airport->magnetic_variation }} <br>
                    <strong>Beacon:</strong> {{ $airport->beacon }} <br>
                    <strong>Max Aircraft Capability:</strong> {{ $airport->max_aircraft_capability }}
                </p>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">🏥 Support Services</h5><br>
                <p>
                    <strong>Air Traffic:</strong> {{ $airport->air_traffic }} <br>
                    <strong>Meteorological:</strong> {{ $airport->meteorological }} <br>
                    <strong>Air Fuel Depot:</strong> {{ $airport->air_fuel_depot }} <br>
                    <strong>Supplies/Equipment:</strong> {{ $airport->supplies_eqipment }} <br>
                    <strong>Internet:</strong> {{ $airport->internet }}
                </p>

                @php
                    $publicfac = $airport->public_facilities;
                    $publicfacexp = explode(', ', $publicfac);
                @endphp
                <p>Public Facilities:</p>
                    <ul>
                        @foreach ($publicfacexp as $pub)
                            <li>{{ $pub }}</li>
                        @endforeach
                    </ul>

                @php
                    $publictran = $airport->public_transportation;
                    $publictranexp = explode(', ', $publictran);
                @endphp
                <p>Public Transportation:</p>
                    <ul>
                        @foreach ($publictranexp as $pubtran)
                            <li>{{ $pubtran }}</li>
                        @endforeach
                    </ul>

            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">🏨 Other Airport Info</h5>
                <br>
                @php
                    $otherair = $airport->other_airport_info;
                    $otherairexp = explode(', ', $otherair);
                @endphp

                    <ul>
                        @foreach ($otherairexp as $oair)
                            <li><a href="{{ $oair }}" target="__blank">{{ $oair }}</a></li>
                        @endforeach
                    </ul>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">🏥 Nearest Accomodation(s)</h5><br>
                <br>
                @php
                    $nearest = $airport->nearest_accommodation;
                    $nearestexp = explode(', ', $nearest);
                @endphp

                    <ul>
                        @foreach ($nearestexp as $near)
                            <li><a href="{{ $near }}" target="__blank">{{ $near }}</a></li>
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
