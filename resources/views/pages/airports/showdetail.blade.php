@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Airports')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />
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

    <div class="card mb-4">
        <div class="card-body">
            <small><i>Last Updated</i></small>
            <small><i>{{ $airport->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-plane"></i> General Airport Info</div>
                <div class="card-body overflow-auto" style="height: 500px;">
                    <div class="col-md-12">
                        <p><strong>Category:</strong> {{ $airport->category }} </p>
                        <p><strong>Classification:</strong> {{ $airport->classification }} </p>
                        <p><strong>IATA Code:</strong> {{ $airport->iata_code }} </p>
                        <p><strong>ICAO Code:</strong> {{ $airport->icao_code }} </p>
                        <p><strong>Hrs of Operation:</strong> {{ $airport->hrs_of_operation }} </p>
                        <p><strong>Distance from:</strong><br>
                            {{ $airport->distance_from }}
                        </p>
                        <p><strong>Time Zone:</strong> {{ $airport->time_zone }} </p>
                        <p><strong>Operator:</strong> {{ $airport->operator }} </p>
                        <p><strong>Magnetic Variation:</strong> {{ $airport->magnetic_variation }} </p>
                        <p><strong>Beacon:</strong> {{ $airport->beacon }}</p>
                        <p><strong>Max Aircraft Capability:</strong> {{ $airport->max_aircraft_capability }} </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="height: 267px;">
                        <div class="card-header fw-bold"><i class="fas fa-phone"></i> Contact Details</div>
                        <div class="card-body overflow-auto">
                            <p><strong>Telephone:</strong> {{ $airport->telephone ?? '-' }}</p>
                            <p><strong>Fax:</strong> {{ $airport->fax ?? '-' }} </p>
                            <p><strong>Email:</strong> <?php echo $airport->email; ?> </p>
                            <p><strong>Website:</strong> <?php echo $airport->website; ?> </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="height: 267px;">
                        <div class="card-header fw-bold"><i class="fas fa-map-marker-alt"></i> Location</div>
                        <div class="card-body overflow-auto">
                            <p><strong>Address:</strong>
                                {{ $airport->address }}, Papua New Guinea
                            </p>
                            <p><strong>Latitude:</strong> {{ $airport->latitude }} </p>
                            <p><strong>Longitude:</strong> {{ $airport->longitude }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">

            <div class="card h-100" style="max-height: 480px;">
                <div class="card-header fw-bold"><i class="fas fa-map"></i> Airport Location Map</div>
                <div class="card-body p-0">
                    <div id="map" style="width: 100%; height: 100%; min-height: 400px;"></div>
                </div>
            </div>

             <div class="card">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">

                        <div class="d-flex align-items-center">

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level6Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:18px; height:18px;">
                                <small>International</small>
                            </button>

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level5Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:18px; height:18px;">
                                <small>Domestic</small>
                            </button>

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level4Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:18px; height:18px;">
                                <small>Regional</small>
                            </button>

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level2Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:18px; height:18px;">
                                <small>Combined</small>
                            </button>

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                <small>Private</small>
                            </button>
                        </div>

                    </div>
                </div>

                 <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center">

                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                        <small>Level 6</small>
                    </button>

                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                        <small>Level 5</small>
                    </button>

                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level44Modal">
                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:24px; height:24px;">
                        <small>Level 4</small>
                    </button>

                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                        <small>Level 3</small>
                    </button>

                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level22Modal">
                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:24px; height:24px;">
                        <small>Level 2</small>
                    </button>

                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level11Modal">
                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:24px; height:24px;">
                        <small>Level 1</small>
                    </button>
                </div>
                </div>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card h-100">
            <div class="card-header fw-bold"><i class="fas fa-info-circle"></i> Support Services</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
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

        <div class="col-md-4">
            <div class="card h-100">
            <div class="card-header fw-bold"><i class="fas fa-plane"></i> Other Airport Info</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                {!! $airport->other_reference_website !!} {{-- Menggunakan {!! !!} jika kontennya HTML --}}
            </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
            <div class="card-header fw-bold"><i class="fas fa-hotel"></i> Nearest Accomodation</div>
            <div class="card-body overflow-auto" style="max-height: 300px;">
                {!! $airport->nearest_accommodation !!} {{-- Menggunakan {!! !!} jika kontennya HTML --}}
            </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="level1Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Private Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Also known as private airfields or airstrips are primarily used for general and private aviation are owned by private individuals, groups, corporations, or organizations operated for their exclusive use that may include limited access for authorized personnel by the owner or manager. Owners are responsible to ensure safe operation, maintenance, repair, and control of who can use the facilities. Typically, they are not open to the public or provide scheduled commercial airline services and cater to private pilots, business aviation, and sometimes small charter operations. Services may be provided if authorized by the appropriate regulatory authority.</p>

        <p class="p-modal">A large majority of private airports are grass or dirt strip fields without services or facilities, they may feature amenities such as hangars, fueling facilities, maintenance services, and ground transportation options tailored to the needs of their owners or users. Private airports are not subject to the same level of regulatory oversight as public airports, but must still comply with applicable aviation regulations, safety standards, and environmental requirements. In the event of an emergency, landing at a private airport is authorized without any prior approval and should be done if landing anywhere else compromises the safety of the aircraft, crew, passengers, or cargo.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level2Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Combined Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Also called "joint-use airport," are used by both civilian and military aircraft, where a formal agreement exists between the military and a local government agency allowing shared access to infrastructure and facilities, typically with separate passenger terminals and designated operating areas, airspace allocation, and aircraft scheduling. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level3Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
             <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Military Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level4Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Regional Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">A small or remote regional domestic airfield usually located in a geographically isolated area, far from major population centers, often with difficult terrain or vast distances from other airports with limited passenger traffic. May have shorter runways, basic facilities, and limited amenities, and basic infrastructure, serving primarily local communities providing access to essential services like medical transport or regional travel, rather than large-scale commercial flights.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level5Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Domestic Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Exclusively manages flights that originate and end within the same country, does not have international customs or border control facilities. Airport often has smaller and shorter runways, suitable for smaller regional aircraft used on domestic routes, and cannot support larger haul aircraft having less developed support services. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level6Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">International Airfield</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Meet standards set by the International Air Transport Association (IATA) and the International Civil Aviation Organization (ICAO), facilitate transnational travel managing flights between countries, have customs and border control facilities to manage passengers and cargo, and may have dedicated terminals for domestic and international flights. International airports have longer runways to accommodate larger, heavier aircraft, are often a main hub for air traffic, and can serve as a base for larger airlines. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level11Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 1</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Village Health Post – Aid Post (VHP)</b></p>
        <p class="p-modal">Basic level primary health care including health promotion, health improvement, and health protection.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level22Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 2</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Community Health Post - Health Sub Center (CHP)</b></p>
        <p class="p-modal">Primary health, ambulatory care, and short stay inpatient and maternity care at the local rural / remote community level, with a minimum of six (6) health workers to ensure safe 24-hour care and treatment.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level33Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 3</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Health Center - Rural / Urban Clinic – Urban Centers (HC-UC)</b></p>
        <p class="p-modal">Primary health and ambulatory care in urban and rural settings, inpatient, maternity, and newborn care in major provincial urban communities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level44Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 4</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>District Hospital - Rural Health Services (DH)</b></p>
        <p class="p-modal">Primary and secondary level clinical services and district wide public health programs.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level55Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 5</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Provincial Hospital, Health Services and Public Health Programs (PHA)</b></p>
        <p class="p-modal">Secondary level & specialist clinical care services, supporting primary health care, integrating public health programs, and patient referral.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 6</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>National Referral Specialist Tertiary and Teaching Hospital - Health Services (NHA)</b></p>
        <p class="p-modal">Complex tertiary level clinical services, supporting primary health care, public health programs, and a formalized patient referral arrangement.</p>
      </div>
    </div>
  </div>
</div>

@endsection

@push('service')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Data utama dari bandara ini
        const airportData = {
            id: {{ $airport->id }},
            name: '{{ $airport->airport_name }}',
            latitude: {{ $airport->latitude }},
            longitude: {{ $airport->longitude }},
            icon: '{{ $airport->icon ?? '' }}', // Pastikan kolom 'icon' ada di model Airport
            image: '{{ $airport->image ?? '' }}', // Tambahkan jika ada kolom image
            address: '{{ $airport->address ?? '' }}',
            telephone: '{{ $airport->telephone ?? '' }}',
            website: '{{ $airport->website ?? '' }}'
        };

        // Data bandara dan rumah sakit terdekat (dari controller)
        const nearbyAirports = @json($nearbyAirports);
        const nearbyHospitals = @json($nearbyHospitals);
        const radiusKm = {{ $radius_km }};

        let map;
        let mainAirportMarker;
        let nearbyMarkersGroup = L.featureGroup();
        let radiusCircle;

        // Default icons jika tidak disediakan oleh database
        const DEFAULT_MAIN_AIRPORT_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png';
        const DEFAULT_HOSPITAL_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png';
        const DEFAULT_AIRPORT_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png';

        // Custom icon untuk bandara utama
        const mainAirportIcon = new L.Icon({
            iconUrl: DEFAULT_MAIN_AIRPORT_ICON_URL,
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        // Fungsi untuk menginisialisasi peta
        function initializeMap() {
            map = L.map('map', {
                fullscreenControl: true
            }).setView([airportData.latitude, airportData.longitude], 12); // Zoom out sedikit untuk melihat area sekitar

            // --- Tile Layers ---
            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            });

            const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                attribution: 'Tiles &copy; Esri',
                maxZoom: 19
            });

            satelliteLayer.addTo(map);

            const baseLayers = {
                "Satelit Map": satelliteLayer,
                "Street Map": osmLayer
            };

            L.control.layers(baseLayers).addTo(map);
            nearbyMarkersGroup.addTo(map); // Tambahkan grup untuk marker terdekat
        }

        // Fungsi untuk menambahkan marker bandara utama dan lingkaran radius
        function addMainAirportAndCircle() {
            mainAirportMarker = L.marker([airportData.latitude, airportData.longitude], { icon: mainAirportIcon })
                .addTo(map)
                .bindPopup(`<b>${airportData.name}</b><br>This is the main airport.`)
                .openPopup();

            // Tambahkan lingkaran radius
            radiusCircle = L.circle([airportData.latitude, airportData.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.2,
                radius: radiusKm * 1000 // Ubah km ke meter
            }).addTo(map);
        }

        // Fungsi untuk menambahkan marker terdekat (bandara dan rumah sakit)
        function addNearbyMarkers(data, defaultIconUrl, detailUrlPrefix, type) {
            data.forEach(item => {
                const itemIcon = L.icon({
                    iconUrl: item.icon || defaultIconUrl, // Gunakan item.icon dari DB, fallback ke default
                    iconSize: [24, 24],
                    iconAnchor: [12, 24],
                    popupAnchor: [0, -20]
                });

                const marker = L.marker([item.latitude, item.longitude], { icon: itemIcon });

                // Gunakan properti yang benar tergantung tipe (airport_name untuk bandara, name untuk rumah sakit)
                const name = item.name || item.airport_name || 'N/A';
                const distance = item.distance ? `<br><strong>Distance:</strong> ${item.distance.toFixed(2)} km` : '';

                marker.bindPopup(`
                    <b>${name}</b> (${type})<br>
                    ${distance}
                `);

                nearbyMarkersGroup.addLayer(marker);
            });
        }

        // Fungsi untuk menyesuaikan batas peta ke semua marker dan lingkaran
        function fitMapToBounds() {
            const bounds = L.featureGroup([mainAirportMarker, nearbyMarkersGroup, radiusCircle]).getBounds();
            if (bounds.isValid()) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        }

        // --- Alur Eksekusi Utama ---
        initializeMap();
        addMainAirportAndCircle();
        addNearbyMarkers(nearbyAirports, DEFAULT_AIRPORT_ICON_URL, 'airports', 'Airport');
        addNearbyMarkers(nearbyHospitals, DEFAULT_HOSPITAL_ICON_URL, 'hospitals', 'Hospital');
        fitMapToBounds();
    });
</script>
@endpush
