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

            <!-- Button 2 -->
            <a href="{{ url('embassiees') }}/{{$embassy->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

        </div>

        <div class="d-flex gap-2 ms-auto">
            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
            <i class="bi bi-hospital fs-3"></i>
                <small>Medical Facilities</small>
            </a>
        </div>
    </div>

    <div class="card-header bg-white">
        <h3>{{ $embassy->name_embassiees }} - Papua New Guinea <small><i>Last Updated</i></small></h3>
        <small><i>{{ $embassy->created_at->format('M Y') }}</i></small>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-body">
                <h5>📞 Contact Information</h5>
                <p>
                    <strong>Telephone:</strong> {{ $embassy->telephone ?? '-' }}<br>
                    <strong>Fax:</strong> {{ $embassy->fax ?? '-' }}<br>
                    <strong>Email:</strong> {{ $embassy->email ?? '-' }}<br>
                    <strong>Website:</strong> <a href="{{ $embassy->website }}" target="_blank">{{ $embassy->website }}</a><br>
                    <strong>Latitude:</strong> {{ $embassy->latitude ?? '-' }}<br>
                    <strong>Longitude:</strong> {{ $embassy->longitude ?? '-' }}
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
            <div class="card-body">
                <h5>📍 Contact Information</h5>
                <p>
                    <strong>Location:</strong> {{ $embassy->location ?? '-' }}
                </p>
            </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
            <div class="card-body">
                <h5>🗺️ Map</h5>
                <div id="map" style="height: 300px;"></div>
            </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
        const map = L.map('map').setView([{{ $embassy->latitude }}, {{ $embassy->longitude }}], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([{{ $embassy->latitude }}, {{ $embassy->longitude }}]).addTo(map)
            .bindPopup('{{ $embassy->name_embassiees }}').openPopup();
</script>

@endpush
