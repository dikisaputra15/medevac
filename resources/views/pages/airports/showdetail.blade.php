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
</style>

@endpush

@section('conten')


    <div class="d-flex justify-content-between p-3" style="background-color: #fbeeee;">
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
            <a href="{{ url('airports') }}/{{$airport->id}}/aircharter" class="btn btn-danger d-flex flex-column align-items-center p-3">
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

<div class="card">
    <!-- Header -->
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title fw-bold">{{ $airport->airport_name }} - Papua New Guinea <small><i>Last Updated</i></small></h4>
            <small><i>{{ $airport->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row g-3">
        <!-- Left Column (col-md-6): Location + Contact + General Info -->
        <div class="col-md-6 d-flex flex-column gap-3">
            <!-- Row: Location + Contact -->
            <div class="row g-3">
                <!-- Location -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header fw-bold">📍 Location</div>
                        <div class="card-body overflow-auto" style="max-height: 300px;">
                            <p><strong>Address:</strong>
                                {{ $airport->address }}, Papua New Guinea
                            </p>
                            <p><strong>Latitude:</strong> {{ $airport->latitude }} </p>
                            <p><strong>Longitude:</strong> {{ $airport->longitude }} </p>
                        </div>
                    </div>
                </div>

                <!-- Contact -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header fw-bold">📞 Contact Details</div>
                        <div class="card-body overflow-auto" style="max-height: 300px;">
                            <p><strong>Telephone:</strong> {{ $airport->telephone ?? '-' }}</p>
                            <p><strong>Fax:</strong> {{ $airport->fax ?? '-' }} </p>
                            <p><strong>Email:</strong> <?php echo $airport->email; ?> </p>
                            <p><strong>Website:</strong> <?php echo $airport->website; ?> </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- General Info -->
            <div class="card h-100">
                <div class="card-header fw-bold">ℹ️ General Airport Info</div>
                <div class="card-body overflow-auto" style="max-height: 300px;">
                    <div class="col-md-6">
                        <p><strong>Category:</strong> {{ $airport->category }} </p>
                        <p><strong>Classification:</strong> {{ $airport->classification }} </p>
                        <p><strong>IATA Code:</strong> {{ $airport->iata_code }} </p>
                        <p><strong>ICAO Code:</strong> {{ $airport->icao_code }} </p>
                        <p><strong>Hrs of Operation:</strong> {{ $airport->hrs_of_operation }} </p>
                        <p><strong>Distance from:</strong><br>
                            {{ $airport->distance_from }}
                        </p>
                        <p><strong>Time Zone:</strong> UTC +10.0</p>
                        <p><strong>Operator:</strong> National Airports Corporation</p>
                        <p><strong>Magnetic Variation:</strong> 5.7 E</p>
                        <p><strong>Beacon:</strong> Yes</p>
                        <p><strong>Max Aircraft Capability:</strong> Boeing 767</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column (col-md-6): Map full height -->
        <div class="col-md-6">
            <div class="card h-100" style="max-height: 620px;">
                <div class="card-header fw-bold">🗺️ Airport Location Map</div>
                <div class="card-body p-0" id="map">

                </div>
            </div>
        </div>

         <div class="col-sm-4">
            <div class="card h-100">
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <div class="card-header fw-bold">🏥 Support Services</div>
                <p>
                    <strong>Air Traffic:</strong> {{ $airport->air_traffic }} <br>
                    <strong>Meteorological:</strong> {{ $airport->meteorology_services }} <br>
                    <strong>Aviation Fuel Depot:</strong> {{ $airport->aviation_fuel_depot }} <br>
                    <strong>Internet:</strong> {{ $airport->internet_services }}
                </p>
                <p>
                    <strong>Supplies / Equipment:</strong>
                </p>
                    <?php echo $airport->supplies_eqipment; ?>

                <p><strong>Public Facilities:</strong></p>
                   <?php echo $airport->public_facilities; ?>

                <p><strong>Public Transportation:</strong></p>
                   <?php echo $airport->public_transportation; ?>

            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card h-100">
            <div class="card-body overflow-auto" style="max-height: 300px;">
                <div class="card-header fw-bold">🏨 Other Airport Info</div>
                <?php echo $airport->other_reference_website; ?>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card h-100">
            <div class="card-body overflow-auto" style="max-height: 300px;">
               <div class="card-header fw-bold">🏥 Nearest Accomodation</div>
                <?php echo $airport->nearest_accommodation; ?>
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
