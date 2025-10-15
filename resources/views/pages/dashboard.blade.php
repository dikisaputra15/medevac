@extends('layouts.master')

@section('title', 'Dashboard')

@section('page-title', 'Papua New Guinea Crisis Management Tools')

@push('styles')

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />

    <style>
        #map {
            height: 700px;
        }
        .filter-container {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .form-check-scrollable {
            max-height: 150px;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
        }
        .total-info {
            background: white;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 0 6px rgba(0,0,0,0.2);
            font-weight: bold;
            margin-left: 10px;
        }

        .select2-container .select2-selection--single {
            height: 45px;
            padding: 6px 12px;
            border: 1px solid #ced4da;
            border-radius: 10px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 30px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 45px;
            right: 10px;
        }

        .p-modal{
            text-align:justify;
        }
        .hospital-legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
            padding: 0 5px;
        }
        .hospital-legend-item img {
            width: 30px;
            height: 30px;
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

        .card-header{
            padding: 0.25rem 1.25rem;
            color: #3c66b5;
            font-weight: bold;
        }

        .mb-4{
            margin-bottom: 0.5rem !important;
        }
    </style>

@endpush

@section('conten')

<div class="card">
    <div class="row" style="background-color: #dfeaf1;">
        <div class="col-md-6">
            <div class="d-flex p-3">
                <div class="d-flex gap-2">

                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end p-3">
                <div class="d-flex gap-2 mt-2">

                    <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                        <i class="bi bi-airplane fs-3"></i>
                        <small>Airports</small>
                    </a>

                    <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                        <small>Medical</small>
                    </a>

                    <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                        <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                        <small>Air Charter</small>
                    </a>

                    <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                        <small>Embassies</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="filter-container p-3">
        <form id="filterForm">
            <div class="row g-3 align-items-end">
                {{-- Filter for Airports --}}
                <div class="col-md-2">
                    <select id="airport_name" class="form-select select21-search" name="airport_name">
                        <option value="">🔍 Airport Name</option>
                        @foreach($airportNames as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="airport_category" class="form-select select22-search" name="airport_category">
                        <option value="">🔍 Airport Category</option>
                        @foreach($airportCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- Filter for Hospitals --}}
                <div class="col-md-2">
                    <select id="hospital_name" class="form-select select23-search" name="hospital_name">
                        <option value="">🔍 Medical Facility Name</option>
                        @foreach($hospitalNames as $name)
                            <option value="{{ $name }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select id="hospital_category" class="form-select select24-search" name="hospital_category">
                        <option value="">🔍 Medical Facility Category</option>
                        @foreach($hospitalCategories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Apply Filter</button>
                    <button type="button" id="resetFilter" class="btn btn-secondary">Reset Filter</button>
                </div>

                <div class="col-md-2">
                    <label for="radiusRange" class="form-label">Search in radius <span id="radiusValue">0</span> kilometers</label>
                    <input type="range" id="radiusRange" name="radius" class="form-control" min="0" max="400" value="0">
                </div>


                <div class="col-md-2">
                    <label class="form-label d-flex align-items-center" style="cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#provinceCollapse" aria-expanded="false" aria-controls="provinceCollapse">
                        <span class="me-1">Provinces Region</span>
                        <i class="bi bi-chevron-down" id="provinceToggleIcon"></i>
                    </label>

                    <div class="collapse" id="provinceCollapse">
                        <div class="form-check-scrollable" style="max-height: 200px; overflow-y: auto; border: 1px solid #ccc; padding: 10px; border-radius: 5px;">
                            @foreach ($provinces as $province)
                                <div class="form-check">
                                    <input class="form-check-input province-checkbox" type="checkbox" name="provinces[]" value="{{ $province->id }}" id="province_{{ $province->id }}">
                                    <label class="form-check-label" for="province_{{ $province->id }}">
                                        {{ $province->provinces_region }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

</div>

<div id="map"></div>
 <div class="card">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center gap-3 my-2">

                        <div class="d-flex align-items-center gap-3">

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level6Modal">
                                <img src="https://concord-consulting.com/static/img/cmt/icon/icon-international-airport-orange.png" style="width:18px; height:18px;">
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
                                <small>Combined (Civil-Military)</small>
                            </button>

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level7Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:18px; height:18px;">
                                <small>Military</small>
                            </button>

                            <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                <small>Private</small>
                            </button>

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

<div class="row justify-content-center mt-3">

    <div class="col-lg-3 col-6">
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="totalHospitalsDisplay">{{ $totalhospital }}</h3>

          <p>Medical Facility</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
        </div>

      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="totalAirportsDisplay">{{ $totalairport }}</h3>

          <p>Airport</p>
        </div>
        <div class="icon">
            <i class="ion ion-pie-graph"></i>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Collapse toggle for provinces
    const provinceCollapse = document.getElementById('provinceCollapse');
    const icon = document.getElementById('provinceToggleIcon');

    provinceCollapse.addEventListener('show.bs.collapse', () => {
        icon.classList.remove('bi-chevron-down');
        icon.classList.add('bi-chevron-up');
    });

    provinceCollapse.addEventListener('hide.bs.collapse', () => {
        icon.classList.remove('bi-chevron-up');
        icon.classList.add('bi-chevron-down');
    });

    // --- Map Initialization ---
    const map = L.map('map', {
        fullscreenControl: true
    }).setView([-6.80188562253168, 144.0733101155011], 6); // Set a broader initial view for PNG

    // --- Define Tile Layers ---
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19,
    });

    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri',
        maxZoom: 19,
    });

    osmLayer.addTo(map);

    const baseLayers = {
        "Street Map": osmLayer,
        "Satelit Map": satelliteLayer
    };
    L.control.layers(baseLayers).addTo(map);

    // --- Global Map State Variables ---
    let airportMarkers = L.featureGroup().addTo(map);
    let hospitalMarkers = L.featureGroup().addTo(map);
    let radiusCircle = null;
    let radiusPinMarker = null;
    let lastClickedLocation = null; // Ini akan menyimpan lokasi klik terakhir (bisa dari peta kosong atau marker)
    let drawnPolygonGeoJSON = null; // Stores the GeoJSON of the drawn polygon

    // --- Leaflet Draw Initialization ---
    const drawnItems = new L.FeatureGroup().addTo(map);
    const drawControl = new L.Control.Draw({
        draw: {
            polygon: {
                allowIntersection: false,
                drawError: {
                    color: '#e1e100',
                    message: '<strong>Oh snap!</strong> you can\'t draw that!'
                },
                shapeOptions: {
                    color: '#0000FF',
                    fillColor: '#0000FF',
                    fillOpacity: 0.2
                }
            },
            polyline: false,
            rectangle: false,
            circle: false,
            marker: false,
            circlemarker: false
        },
        edit: {
            featureGroup: drawnItems,
            remove: true,
            poly: {
                allowIntersection: false,
                color: '#0000FF',
                fillColor: '#0000FF',
                fillOpacity: 0.2
            }
        }
    });
    map.addControl(drawControl);

    // --- Leaflet Draw Event Handlers ---
    map.on(L.Draw.Event.CREATED, function (event) {
        const layer = event.layer;
        drawnItems.clearLayers();
        drawnItems.addLayer(layer);
        drawnPolygonGeoJSON = layer.toGeoJSON();
        if (layer instanceof L.Polygon) {
            layer.setStyle({
                color: '#0000FF',
                fillColor: '#0000FF',
                fillOpacity: 0.2
            });
        }
        applyFilters();
    });

    map.on(L.Draw.Event.EDITED, function (event) {
        event.layers.eachLayer(function (layer) {
            drawnPolygonGeoJSON = layer.toGeoJSON();
            if (layer instanceof L.Polygon) {
                layer.setStyle({
                    color: '#0000FF',
                    fillColor: '#0000FF',
                    fillOpacity: 0.2
                });
            }
        });
        applyFilters();
    });

    map.on(L.Draw.Event.DELETED, function (event) {
        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null;
        applyFilters();
    });

    // --- Custom Controls ---
    // const totalControl = L.control({ position: 'topright' });
    // totalControl.onAdd = function (map) {
    //     const div = L.DomUtil.create('div', 'total-info');
    //     div.innerHTML = 'Loading counts...';
    //     return div;
    // };
    // totalControl.addTo(map);

    // function updateCounters(airportCount, hospitalCount) {
    //     document.getElementById('totalAirportsDisplay').innerText = airportCount;
    //     document.getElementById('totalHospitalsDisplay').innerText = hospitalCount;
    //     totalControl.getContainer().innerHTML = `Total Airports: ${airportCount}<br>Total Hospitals: ${hospitalCount}`;
    // }

    // --- Radius Search Functionality ---
    function updateRadiusCircleAndPin() {
        if (radiusCircle) {
            map.removeLayer(radiusCircle);
            radiusCircle = null;
        }
        if (radiusPinMarker) {
            map.removeLayer(radiusPinMarker);
            radiusPinMarker = null;
        }

        const radius = parseInt(document.getElementById('radiusRange').value);
        if (radius > 0 && lastClickedLocation) {
            radiusCircle = L.circle(lastClickedLocation, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.3,
                radius: radius * 1000
            }).addTo(map);

            const redIcon = new L.Icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                shadowSize: [41, 41]
            });
            radiusPinMarker = L.marker(lastClickedLocation, { icon: redIcon }).addTo(map);
        }
    }

    document.getElementById('radiusRange').addEventListener('input', function() {
        document.getElementById('radiusValue').textContent = this.value;
        updateRadiusCircleAndPin();
        // applyFilters(); // Anda bisa mengaktifkan ini jika ingin filter diterapkan secara langsung saat slider radius digeser
    });

    // Ini adalah event listener untuk klik pada peta kosong
    map.on('click', function(e) {
        lastClickedLocation = { lat: e.latlng.lat, lng: e.latlng.lng };
        updateRadiusCircleAndPin();
    });

    // --- Data Fetching Functions ---
    async function fetchData(url, filters) {
        const params = new URLSearchParams();
        Object.keys(filters).forEach(key => {
            if (Array.isArray(filters[key])) {
                filters[key].forEach(value => params.append(`${key}[]`, value));
            } else if (filters[key] !== '' && filters[key] !== null) {
                params.append(key, filters[key]);
            }
        });

        if (drawnPolygonGeoJSON) {
            params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        }

        if (filters.radius > 0 && filters.center_lat && filters.center_lng) {
            params.append('radius', filters.radius);
            params.append('center_lat', filters.center_lat);
            params.append('center_lng', filters.center_lng);
        }

        try {
            const response = await fetch(`${url}?${params.toString()}`);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error(`Error fetching data from ${url}:`, error);
            return [];
        }
    }

   function addMarkersToMap(data, markerGroup, iconUrl) { // Menghapus parameter detailUrlPrefix karena akan ditentukan secara dinamis
    markerGroup.clearLayers();
    data.forEach(item => {
        const itemIcon = L.icon({
            iconUrl: item.icon || iconUrl,
            iconSize: [24, 24],
            iconAnchor: [12, 24],
            popupAnchor: [0, -20]
        });

        const marker = L.marker([item.latitude, item.longitude], { icon: itemIcon }).addTo(markerGroup);

        // Tambahkan event listener click ke setiap marker
        marker.on('click', function() {
            lastClickedLocation = {
                lat: item.latitude,
                lng: item.longitude
            };
            updateRadiusCircleAndPin(); // Perbarui radius dan pin ke lokasi marker yang diklik
        });

        // --- AWAL PERUBAHAN PENTING DI SINI ---
        let popupContent = ``;
        let detailUrl = '';
        let itemName = '';

        // Deteksi apakah item adalah Airport atau Hospital
        // Asumsi: Airport memiliki 'airport_name', Hospital memiliki 'name'
        if (item.airport_name) {
            // Ini adalah Airport
            itemName = item.airport_name;
            detailUrl = `/airports/${item.id}/detail`; // URL detail untuk Airport
            popupContent = `
                <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                <strong>Address:</strong> ${item.address || 'N/A'}<br>
                <strong>Telephone:</strong> ${item.telephone || 'N/A'}<br>
                ${item.website ? `<strong>Website:</strong><a href='${item.website}' target='__blank'> ${item.website} </a><br>` : ''}
            `;
        } else if (item.name) {
            // Ini adalah Hospital
            itemName = item.name;
            detailUrl = `/hospitals/${item.id}`; // URL detail untuk Hospital (PASTIKAN ROUTE INI ADA DI LARAVEL)
            popupContent = `
                <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                <strong>Address:</strong> ${item.address || 'N/A'}<br>
                <strong>Coords:</strong> ${item.latitude}, ${item.longitude}<br>
                <strong>Province:</strong> ${item.provinces_region || 'N/A'}<br>
                <strong>Level:</strong> ${item.facility_level || 'N/A'}<br>
            `;
        } else {
            // Fallback jika tidak teridentifikasi (opsional, tapi baik untuk debugging)
            itemName = item.id ? `Item ID: ${item.id}` : 'Unknown Item';
            popupContent = `<b>${itemName}</b><br>Data detail tidak tersedia.`;
        }

        // Tambahkan tombol Read More jika ada ID dan URL detail
        if (item.id && detailUrl) {
            popupContent += `<a href="${detailUrl}" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>`;
        }
        // --- AKHIR PERUBAHAN PENTING DI SINI ---

        marker.bindPopup(popupContent);
    });
    return data.length;
}

    // --- Main Filter Application Logic ---
    async function applyFilters() {
        const airportName = document.getElementById('airport_name').value;
        const airportCategory = document.getElementById('airport_category').value;

        const hospitalName = document.getElementById('hospital_name').value;
        const hospitalCategory = document.getElementById('hospital_category').value;

        const radius = parseInt(document.getElementById('radiusRange').value);
        const selectedProvinces = Array.from(document.querySelectorAll('.province-checkbox:checked'))
                                     .map(checkbox => checkbox.value);

        let commonFilters = {
            provinces: selectedProvinces
        };

        if (radius > 0 && lastClickedLocation) {
            commonFilters.radius = radius;
            commonFilters.center_lat = lastClickedLocation.lat;
            commonFilters.center_lng = lastClickedLocation.lng;
        }

        const airportFilters = {
            name: airportName,
            category: airportCategory,
            ...commonFilters
        };
        const airports = await fetchData('/api/airports', airportFilters);
        const airportCount = addMarkersToMap(airports, airportMarkers, 'https://unpkg.com/leaflet/dist/images/marker-icon.png', '/airports');

        const hospitalFilters = {
            name: hospitalName,
            category: hospitalCategory,
            ...commonFilters
        };
        const hospitals = await fetchData('/api/hospital', hospitalFilters);
        const hospitalCount = addMarkersToMap(hospitals, hospitalMarkers, 'https://unpkg.com/leaflet/dist/images/marker-icon.png', '/hospitals');

        // updateCounters(airportCount, hospitalCount);
        updateRadiusCircleAndPin(); // Ensure the radius circle and pin are updated after filters are applied

        // Adjust map view to fit all markers and drawn items
        let combinedBounds = L.featureGroup();
        if (airportMarkers.getLayers().length > 0) combinedBounds.addLayer(airportMarkers);
        if (hospitalMarkers.getLayers().length > 0) combinedBounds.addLayer(hospitalMarkers);
        if (drawnItems.getLayers().length > 0) combinedBounds.addLayer(drawnItems);
        if (radiusCircle) combinedBounds.addLayer(radiusCircle);
        if (radiusPinMarker) combinedBounds.addLayer(radiusPinMarker);

        if (combinedBounds.getLayers().length > 0) {
            map.fitBounds(combinedBounds.getBounds(), { padding: [50, 50] });
        } else if (lastClickedLocation) {
            map.setView(lastClickedLocation, 10);
        } else {
            map.setView([-6.80188562253168, 144.0733101155011], 6);
        }

        // Save filter state to localStorage
        const currentFilters = {
            airport_name: airportName,
            airport_category: airportCategory,
            hospital_name: hospitalName,
            hospital_category: hospitalCategory,
            radius: radius,
            provinces: selectedProvinces,
            center_lat: lastClickedLocation ? lastClickedLocation.lat : null,
            center_lng: lastClickedLocation ? lastClickedLocation.lng : null,
        };
        localStorage.setItem('mapFilterState', JSON.stringify(currentFilters));
        localStorage.setItem('mapDrawnPolygon', JSON.stringify(drawnPolygonGeoJSON));
        localStorage.setItem('mapLastClickedLocation', JSON.stringify(lastClickedLocation));
    }

    // --- Load Filters and Apply on Page Load ---
    async function loadFiltersAndApply() {
        // Initialize Select2 first
        $('.select21-search').select2({
            placeholder: "🔍 Airport Name",
            allowClear: true,
            width: '100%',
        });

        $('.select22-search').select2({
            placeholder: "🔍 Airport Category",
            allowClear: true,
            width: '100%',
        });

         $('.select23-search').select2({
            placeholder: "🔍 Medical Facility Name",
            allowClear: true,
            width: '100%',
        });

        $('.select24-search').select2({
            placeholder: "🔍 Medical Facility Category",
            allowClear: true,
            width: '100%',
        });

        const savedFilterStateString = localStorage.getItem('mapFilterState');
        const savedPolygonString = localStorage.getItem('mapDrawnPolygon');
        const savedLocationString = localStorage.getItem('mapLastClickedLocation');

        if (savedFilterStateString) {
            const savedFilters = JSON.parse(savedFilterStateString);

            // Populate form fields
            document.getElementById('airport_name').value = savedFilters.airport_name || '';
            document.getElementById('airport_category').value = savedFilters.airport_category || '';
            document.getElementById('hospital_name').value = savedFilters.hospital_name || '';
            document.getElementById('hospital_category').value = savedFilters.hospital_category || '';

            const savedRadius = parseInt(savedFilters.radius) || 0;
            document.getElementById('radiusRange').value = savedRadius;
            document.getElementById('radiusValue').textContent = savedRadius;

            // Handle province checkboxes
            const savedProvinces = savedFilters.provinces || [];
            document.querySelectorAll('.province-checkbox').forEach(checkbox => {
                checkbox.checked = savedProvinces.includes(checkbox.value);
            });

            // Trigger Select2 updates
            $('#airport_name').val(savedFilters.airport_name).trigger('change');
            $('#airport_category').val(savedFilters.airport_category).trigger('change');
            $('#hospital_name').val(savedFilters.hospital_name).trigger('change');
            $('#hospital_category').val(savedFilters.hospital_category).trigger('change');

            if (savedLocationString && savedLocationString !== 'null') {
                lastClickedLocation = JSON.parse(savedLocationString);
            }

            if (savedPolygonString && savedPolygonString !== 'null') {
                drawnPolygonGeoJSON = JSON.parse(savedPolygonString);
                if (drawnPolygonGeoJSON && drawnPolygonGeoJSON.geometry && drawnPolygonGeoJSON.geometry.coordinates) {
                    const layer = L.geoJSON(drawnPolygonGeoJSON, {
                        style: function (feature) {
                            return {
                                color: '#0000FF',
                                fillColor: '#0000FF',
                                fillOpacity: 0.2
                            };
                        }
                    });
                    drawnItems.clearLayers();
                    drawnItems.addLayer(layer);
                    if (map.editTools && layer.editing) {
                         layer.editing.enable();
                    }
                }
            }
        }
        await applyFilters();
    }

    // --- Event Listeners ---
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        applyFilters();
    });

    document.getElementById('resetFilter').addEventListener('click', function() {
        document.getElementById('filterForm').reset();
        document.getElementById('radiusValue').textContent = '0';
        document.querySelectorAll('.province-checkbox').forEach(checkbox => {
            checkbox.checked = false;
        });

        // Reset Select2
        $('#airport_name').val(null).trigger('change');
        $('#airport_category').val(null).trigger('change');
        $('#hospital_name').val(null).trigger('change');
        $('#hospital_category').val(null).trigger('change');

        if (radiusCircle) {
            map.removeLayer(radiusCircle);
            radiusCircle = null;
        }
        if (radiusPinMarker) {
            map.removeLayer(radiusPinMarker);
            radiusPinMarker = null;
        }

        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null;
        lastClickedLocation = null;

        localStorage.removeItem('mapFilterState');
        localStorage.removeItem('mapDrawnPolygon');
        localStorage.removeItem('mapLastClickedLocation');

        applyFilters();
    });

    // Initial load and filter application
    loadFiltersAndApply();
</script>

@endpush
