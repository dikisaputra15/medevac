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
            <a href="{{ url('hospital') }}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

            <!-- Button 2 -->
            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-hospital fs-3"></i>
                <small>Clinical Services</small>
            </a>

            <!-- Button 4 -->
            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>

        </div>

        <div class="d-flex gap-2 ms-auto">
            <!-- Button 5 -->
            <a href="" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <!-- Button 6 -->
            <a href="" class="btn btn-danger d-flex flex-column align-items-center p-3">
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
        <h3>{{ $hospital->name }} - Papua New Guinea <small><i>Last Updated</i></small></h3>
        <small><i>{{ $hospital->created_at->format('M Y') }}</i></small>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5>📍 Location</h5>
                <p>
                    <strong>Address:</strong>
                    {{ $hospital->address }},
                    {{ $hospital->region }}, Papua New Guinea
                </p>
                <p>
                    <strong>Latitude:</strong> {{ $hospital->latitude }}<br>
                    <strong>Longitude:</strong> {{ $hospital->longitude }}
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5>📞 Contact Details</h5>
                @php
                    $telephoneNumbers = $hospital->telephone;
                    $numbersArray = explode(', ', $telephoneNumbers);
                @endphp
                    <strong>Telephone:</strong><br>
                    <ul>
                        @foreach ($numbersArray as $tlp)
                            <li>{{ $tlp }}</li>
                        @endforeach
                    </ul>
                <p>
                    <strong>Email:</strong> {{ $hospital->email ?? '-' }}<br>
                    <strong>Website:</strong>
                    <a href="{{ $hospital->website }}" target="_blank">{{ $hospital->website }}</a>
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
                <h5 class="card-title">🏥 General Medical Facility Info</h5><br>
                <p>
                    <strong>Facility Level:</strong> {{ $hospital->facility_level }} <br>
                    <strong>Status:</strong> {{ $hospital->status }} <br>
                    <strong>House Of Operations:</strong> {{ $hospital->house_of_operations }} <br>
                    <strong>- Emergency Services:</strong> {{ $hospital->emergency_services }} <br>
                    <strong>- Outpatient Services:</strong> {{ $hospital->outpatient_services_general }} <br>
                    <strong>- Inpatient Services:</strong> {{ $hospital->inpatient_services_general }} <br>
                    <strong>Number Of Beds:</strong> {{ $hospital->number_of_beds }} <br>
                    <strong>Population Catchment:</strong> {{ $hospital->population_catchment }} <br>
                    <strong>Ownership:</strong> {{ $hospital->ownership }}
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h5 class="card-title">🏨 Nearest Accommodation(s)</h5>
                <br>
                @php
                    $nearests = $hospital->nearest_accommodations;
                    $nearestsexp = explode(', ', $nearests);
                @endphp

                    <ul>
                        @foreach ($nearestsexp as $near)
                            <li>{{ $near }}</li>
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
        const map = L.map('map').setView([{{ $hospital->latitude }}, {{ $hospital->longitude }}], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([{{ $hospital->latitude }}, {{ $hospital->longitude }}]).addTo(map)
            .bindPopup('{{ $hospital->name }}').openPopup();
</script>

@endpush
