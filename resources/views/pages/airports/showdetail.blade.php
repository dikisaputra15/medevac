@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Airports')

@push('styles')
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

    p {
        margin-bottom: 8px;
        line-height: 18px;
    }

    .btn-danger {
        background-color:#395272;
        border-color: transparent;
    }

    .btn-danger:hover {
        background-color:#5686c3;
        border-color: transparent;
    }

    .btn.active {
        background-color: #5686c3 !important;
        border-color: transparent !important;
        color: #fff !important;
    }

    .p-3 {
        padding: 10px !important;
        margin: 0 3px;
    }

    .btn-outline-danger {
        color: #FFFFFF;
        background-color:#395272;
        border-color: transparent;
    }

    .btn-outline-danger:hover {
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

    .card-header{
        padding: 0.25rem 1.25rem;
    }

    .mb-4{
        margin-bottom: 0.5rem !important;
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

            <a href="{{ url('airports') }}/{{$airport->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/detail') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <a href="{{ url('airports') }}/{{$airport->id}}/navigation" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/navigation') ? 'active' : '' }}">
                <i class="bi bi-compass fs-3"></i>
                <small>Navigation</small>
            </a>

            <a href="{{ url('airports') }}/{{$airport->id}}/airlinesdestination" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/airlinesdestination') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Airlines/Destination</small>
            </a>

            <a href="{{ url('airports') }}/{{$airport->id}}/emergency" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports/'.$airport->id.'/emergency') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                <i class="bi bi-hospital fs-3"></i>
                <small>Medical Facility</small>
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

    <div class="card mb-4 position-relative">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated {{ $airport->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('airportdata.edit', $airport->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>


    <div class="row">
         <div class="col-md-4">
                <div class="card">
                        <div class="card-header fw-bold"><i class="fas fa-plane"></i> General Airport Info</div>
                        <div class="card-body overflow-auto">
                            <p><strong>Category:</strong> {{ $airport->category }} </p>
                            <p><strong>IATA Code:</strong> {{ $airport->iata_code }} </p>
                            <p><strong>ICAO Code:</strong> {{ $airport->icao_code }} </p>
                            <p><strong>Hrs of Operation:</strong> {{ $airport->hrs_of_operation }} </p>
                            <p><strong>Distance from:</strong><br>
                                <?php echo $airport->distance_from; ?>
                            </p>
                            <p><strong>Elevation:</strong> {{ $airport->elevation }} </p>
                            <p><strong>Time Zone:</strong> {{ $airport->time_zone }} </p>
                            <p><strong>Operator:</strong> {{ $airport->operator }} </p>
                            <p><strong>Magnetic Variation:</strong> {{ $airport->magnetic_variation }} </p>
                            <p><strong>Beacon:</strong> {{ $airport->beacon }}</p>
                            <p><strong>Max Aircraft Capability:</strong> {{ $airport->max_aircraft_capability }} </p>
                            <p><strong>Directorate General of Civil Aviation:</strong> {!! $airport->dgoca !!}  </p>
                            <p><strong>State-Owned Aviation Operator:</strong> {!! $airport->soao !!}  </p>
                            <p><strong>Other Airport Info:</strong> {!! $airport->other_reference_website !!}  </p>
                            @if(!empty($airport->note))
                                <p><strong>Note:</strong> {!! $airport->note !!} </p>
                            @endif

                        </div>
                </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-phone"></i> Contact Details</div>
                <div class="card-body overflow-auto">
                    <p><strong>Telephone:</strong> <?php echo $airport->telephone; ?></p>
                    <p><strong>Fax:</strong> <?php echo $airport->fax; ?> </p>
                    <p><strong>Email:</strong> <?php echo $airport->email; ?> </p>
                    <p><strong>Website:</strong> <?php echo $airport->website; ?> </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-map-marker-alt"></i> Location</div>
                <div class="card-body overflow-auto">
                    <p><strong>Address:</strong>
                        {{ $airport->address }}, {{ $province->provinces_region }}, Papua New Guinea
                    </p>
                    <p><strong>Latitude:</strong> {{ $airport->latitude }} </p>
                    <p><strong>Longitude:</strong> {{ $airport->longitude }} </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-hotel"></i> Nearest Accomodation</div>
                <div class="card-body overflow-auto">
                    {!! $airport->nearest_accommodation !!} {{-- Menggunakan {!! !!} jika kontennya HTML --}}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-info-circle"></i> Support Services</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Air Traffic:</strong> {{ $airport->air_traffic }} <br>
                        <strong>Meteorological:</strong> {{ $airport->meteorology_services }} <br>
                        <strong>Aviation Fuel Depot:</strong> {{ $airport->aviation_fuel_depot }} <br>
                        <strong>Internet:</strong> {{ $airport->internet_services }}
                    </p>
                    <p>
                        <strong>Supplies / Equipment:</strong>
                    </p>
                    {!! $airport->supplies_eqipment !!} {{-- Menggunakan {!! !!} jika kontennya HTML --}}

                    <p><strong>Public Facilities:</strong></p>
                    {!! $airport->public_facilities !!} {{-- Menggunakan {!! !!} jika kontennya HTML --}}

                    <p><strong>Public Transportation:</strong></p>
                    {!! $airport->public_transportation !!} {{-- Menggunakan {!! !!} jika kontennya HTML --}}

                </div>
            </div>
        </div>

    </div>

</div>

@endsection

@push('service')

@endpush
