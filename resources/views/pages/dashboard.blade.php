@extends('layouts.master')

@section('title', 'Dashboard')

@section('page-title', 'Papua New Guinea Crisis Management Tools')

@push('styles')

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.css" />

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

        /* Classification section */
    .classification {
      display: flex;
      width: 100%;
    }

    .class-column {
      flex: 1;
      text-align: center;

    }
    .class-column:last-child {
      border-right: none;
    }

    .class-header {
      font-weight: 600;
      padding: 0.1rem 0;
    }

    /* Color bars */
    .class-medical-classification {border: none; text-align: center;}
    .class-airport-category {border: none;}
    .class-advanced { border-bottom: 3px solid #0070c0; }
    .class-intermediate { border-bottom: 3px solid #00b050; }
    .class-basic { border-bottom: 3px solid #ffc000; }

    /* Hospital layout */
    .hospital-list {
      display: flex;
      flex-direction: column;
      align-items: center;

    }

    /* For side-by-side classes */
    .hospital-row {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 0;
    }

    .hospital-item {
      display: flex;
      align-items: center;
      gap: 0;
      font-size: 0.9rem;
      white-space: nowrap;
    }

    .hospital-icon {
      width: 18px;
      height: 18px;
      border-radius: 3px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }

    /* Image inside icon box */
    .hospital-icon img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Airfield icons */
    .category-item img {
      width: 16px;
      height: 16px;
      object-fit: contain;
    }

     .filter-box {
        position: relative;
        width: 100%;
    }

    .filter-label {
        font-weight: 600;
        margin-bottom: 5px;
        display: block;
    }

    .select-input {
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 8px 10px;
        background: #fff;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .select-input input {
        border: none;
        width: 100%;
        cursor: pointer;
        background: transparent;
        outline: none;
    }

    .select-dropdown {
        display: none;
        position: absolute;
        width: 100%;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-top: 3px;
        z-index: 9999;
        max-height: 250px;
        overflow: hidden;
    }

    .select-dropdown.show {
        display: block;
    }

    .dropdown-search {
        width: 100%;
        border: none;
        border-bottom: 1px solid #ddd;
        padding: 8px;
        outline: none;
    }

    #provinceList {
        list-style: none;
        padding: 0;
        margin: 0;
        max-height: 180px;
        overflow-y: auto;
    }

    #provinceList li {
        padding: 5px 10px;
    }

    #provinceList li:hover {
        background: #f5f5f5;
    }

    #provinceList label {
        width: 100%;
        margin: 0;
        cursor: pointer;
    }
</style>

@endpush

@section('conten')

<div class="card">
    <div class="row" style="background-color: #dfeaf1;">
        <div class="col-md-9">
            <div class="d-flex p-3" style="justify-content: center;">
                <div class="d-flex gap-2">

                <!-- Airport -->
                      <div class="class-column" style="margin-right: 100px;">
                        <div class="class-header class-airport-category">Airfield Classification</div>
                        <div class="airport-list">
                          <div class="hospital-row" style="flex-direction: column;">
                            <!-- Airport row 1 -->
                            <div class="hospital-item">
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
                            </div>
                            <!-- Airport row 2 -->
                            <div class="hospital-item">
                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level2Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:18px; height:18px;">
                                  <small>Civil-Military</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level3Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:18px; height:18px;">
                                  <small>Military</small>
                              </button>

                              <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                  <small>Private</small>
                              </button>
                            </div>
                          </div>

                        </div>
                      </div>

                      <!-- Medical Facility Legend -->
                      <div style="flex-direction: column;">
                        <!-- Title -->
                        <div>
                            <div class="class-header class-medical-classification">Medical Facility Classification</div>
                        </div>
                        <div style="display: flex; flex-direction: row;">
                            <!-- Advanced -->
                            <div class="class-column">
                              <div class="class-header class-advanced">Advanced</div>
                              <div class="hospital-list">
                                <div class="hospital-item">
                                  <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                                    <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                                    <small>Level 6</small>
                                  </button>
                                </div>
                              </div>
                            </div>

                            <!-- Intermediate -->
                            <div class="class-column">
                              <div class="class-header class-intermediate">Intermediate</div>
                              <div class="hospital-list">
                                <div class="hospital-row">
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                                      <small>Level 5</small>
                                    </button>
                                  </div>
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level44Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:24px; height:24px;">
                                      <small>Level 4</small>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <!-- Basic -->
                            <div class="class-column">
                              <div class="class-header class-basic">Basic</div>
                              <div class="hospital-list">
                                <div class="hospital-row">
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                                      <small>Level 3</small>
                                    </button>
                                  </div>
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level22Modal">
                                      <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:24px; height:24px;">
                                      <small>Level 2</small>
                                    </button>
                                  </div>
                                  <div class="hospital-item">
                                    <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level11Modal">
                                        <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:24px; height:24px;">
                                        <small>Level 1</small>
                                    </button>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>

                       <div class="class-column" style="margin-left: 50px;">
                        <div class="class-header class-airport-category">POLICE CLASSIFICATION</div>

                        <div class="airport-list">
                            <div class="hospital-row" style="flex-direction: column;">

                                <!-- Baris Atas (3) -->
                                <div class="hospital-item">
                                    <button class="btn p-1">
                                        <img src="{{ asset('images/dot-blue-ring-royal-papua.png') }}" style="width:12px; height:12px;">
                                        <small>Royal Papua New Guinea Constabulary (Commissioner HQ)</small>
                                    </button>

                                    <button class="btn p-1">
                                        <img src="{{ asset('images/dot-red.png') }}" style="width:12px; height:12px;">
                                        <small>Divisional Command</small>
                                    </button>
                                </div>

                                <!-- Baris Bawah (2) -->
                                <div class="hospital-item">
                                    <button class="btn p-1">
                                         <img src="{{ asset('images/dot-orange-ppc.png') }}" style="width:12px; height:12px;">
                                        <small>Provincial Police Command (PPC)</small>
                                    </button>

                                    <button class="btn p-1">
                                        <img src="{{ asset('images/dot-green.png') }}" style="width:12px; height:12px;">
                                        <small>District Police Command / Police Station</small>
                                    </button>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-3">
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

                    <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
                    <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                        <small>Police</small>
                    </a>

                    <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
                    <img src="{{ asset('images/icon-embassy.png') }}" style="width: 24px; height: 24px;">
                        <small>Embassies</small>
                    </a>
                </div>
            </div>
        </div>
    </div>

     <div class="col-md-12">
        <button class="btn btn-link p-0 fw-bold text-decoration-underline text-dark" data-bs-toggle="modal" data-bs-target="#disclaimerModal">
            <i class="bi bi-info-circle text-primary fs-5"></i>
            <small>Disclaimer</small>
        </button>
    </div>

</div>

<div id="map"></div>

<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disclaimerLabel">Disclaimer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <p class="p-modal text-justify">Every attempt has been made to ensure the completeness and accuracy of the most updated information and data available. Clients are advised, however, that provided information, and data is subject to change.</p>
       <h5 class="modal-title" id="disclaimerLabel">Google Maps Link</h5>
       <p class="p-modal text-justify">Google Maps may automatically display or translate content based on the user’s current region, browser settings, or Google account preferences. This issue may occur when opening google maps link from TCMT platform using Microsoft Edge. For the best experience, we recommend opening the Google Chrome link while logged into your Google account. You can also use your browser’s translation feature to view Google Maps in your preferred language.</p>
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
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Level 1 – Village Health Post – Aid Post (VHP)</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
                Level 1 facility is the most basic healthcare delivery point in Papua New Guinea, typically located in rural or remote communities and staffed by a community health worker or aid post orderly. Aid posts provides essential first-contact care, health education, and basic treatment for common conditions, referring patients to higher-level facilities as needed, and plays a critical role in extending primary healthcare access under Papua New Guinea National Department of Health.
            </p>
             <h6 class="fw-bold">
                <b>Role</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>First point of contact for healthcare in remote communities</li>
                    <li>Provides basic treatment and health education</li>
                    <li>Refers patients to Level 2 or Level 3 facilities</li>
                    <li>Supports community-based public health activities</li>
                </ul>
            </p>
            <h6 class="fw-bold">
                <b>Clinical Services</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Bed Capacity: No inpatient beds</li>
                    <li>
                        <strong>Core Services</strong>
                        <ul>
                            <li>Basic first aid and treatment</li>
                            <li>Management of common minor illnesses</li>
                            <li>Maternal and child health support (basic)</li>
                            <li>Health education to community</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Emergency Services</strong>
                        <ul>
                            <li>Initial stabilization and referral</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostic</strong>
                        <ul>
                            <li>No formal diagnostic services</li>
                            <li>Symptom-based assessment only</li>
                        </ul>
                    </li>
                </ul>
            </p>
             <h5 class="fw-bold" style="color:#3c8dbc;">
                Papua New Guinea Government Health System
            </h5>
            <p class="text-justify">
                Papua New Guinea operates a state-led, tax-funded public health system without a unified national health insurance scheme. The system is administered by Papua New Guinea National Department of Health and delivered through a decentralized network of provincial and district health services.
            </p>
            <p class="text-justify">
                Healthcare financing is primarily derived from:
                <ul>
                    <li>General government taxation</li>
                    <li>Significant external donor support</li>
                </ul>
                Papua New Guinea does not operate parallel insurance schemes. Instead, the system is structured around public service provision with limited user fees, supplemented by private out-of-pocket payments and employer-based arrangements.
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Public Health Service Delivery System (Government & Provincial Health Authorities)
            </h5>
            <p class="text-justify">
                Papua New Guinea’s primary healthcare system is delivered through a nationwide network of public facilities managed by Provincial Health Authorities (PHAs) under the policy direction of the National Department of Health. It covers most of the population, particularly in rural and remote areas.
            </p>
            <p class="text-justify">
                The system is largely financed through government budgets, meaning services are free or low-cost at the point of care, especially for essential health services.
            </p>
            <p class="text-justify">
                Care is delivered through a tiered referral system (Level 1–6), with patients typically accessing care through primary-level facilities before being referred to higher-level hospitals.
            </p>
            <p class="text-justify">
                Public providers include:
                <ul>
                    <li>Aid Posts, Health Sub-centers, and Health Centers (primary care)</li>
                    <li>District, Provincial, and Regional / National Hospitals (secondary and tertiary care)</li>
                </ul>
                This structure emphasizes primary healthcare, disease prevention, and maternal-child health services, but patient choice of provider is limited, particularly in rural areas.
            </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level22Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Level 2 – Community Health Post - Health Sub Centre (CHP)</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
                Level 2 facility is a small primary care facility in Papua New Guinea providing basic outpatient and preventive services, typically staffed by community health workers or nursing staff. Level 2 facilities are an intermediary between aid posts (Level 1) and health centers (Level 3), managing minor conditions and referring patients requiring higher-level care upward, while supporting local public health outreach under the Papua New Guinea National Department of Health.
            </p>
             <h6 class="fw-bold">
                <b>Role</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Provides basic healthcare to local communities</li>
                    <li>Supports preventive and maternal-child health services</li>
                    <li>First structured primary care point above aid posts</li>
                    <li>Receives referrals from Level 1 facilities</li>
                    <li>Refers patients to Level 3 health centre or higher</li>
                    <li>Supports immunization and outreach programs</li>
                </ul>
            </p>
            <h6 class="fw-bold">
                <b>Clinical Services</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Bed Capacity: Typically 0–10 beds (very limited or no inpatient care)</li>
                    <li>
                        <strong>Core Services</strong>
                        <ul>
                            <li>Basic outpatient care</li>
                            <li>Treatment of minor illnesses and injuries</li>
                            <li>Maternal and child health (basic services)</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Emergency Services</strong>
                        <ul>
                            <li>First aid and basic stabilization</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostic</strong>
                        <ul>
                            <li>Minimal diagnostics</li>
                            <li>Rapid tests (where available)</li>
                        </ul>
                    </li>
                </ul>
            </p>
             <h5 class="fw-bold" style="color:#3c8dbc;">
                Papua New Guinea Government Health System
            </h5>
            <p class="text-justify">
                Papua New Guinea operates a state-led, tax-funded public health system without a unified national health insurance scheme. The system is administered by Papua New Guinea National Department of Health and delivered through a decentralized network of provincial and district health services.
            </p>
            <p class="text-justify">
                Healthcare financing is primarily derived from:
                <ul>
                    <li>General government taxation</li>
                    <li>Significant external donor support</li>
                </ul>
                Papua New Guinea does not operate parallel insurance schemes. Instead, the system is structured around public service provision with limited user fees, supplemented by private out-of-pocket payments and employer-based arrangements.
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Public Health Service Delivery System (Government & Provincial Health Authorities)
            </h5>
            <p class="text-justify">
                Papua New Guinea’s primary healthcare system is delivered through a nationwide network of public facilities managed by Provincial Health Authorities (PHAs) under the policy direction of the National Department of Health. It covers most of the population, particularly in rural and remote areas.
            </p>
            <p class="text-justify">
                The system is largely financed through government budgets, meaning services are free or low-cost at the point of care, especially for essential health services.
            </p>
            <p class="text-justify">
                Care is delivered through a tiered referral system (Level 1–6), with patients typically accessing care through primary-level facilities before being referred to higher-level hospitals.
            </p>
            <p class="text-justify">
                Public providers include:
                <ul>
                    <li>Aid Posts, Health Sub-centers, and Health Centers (primary care)</li>
                    <li>District, Provincial, and Regional / National Hospitals (secondary and tertiary care)</li>
                </ul>
                This structure emphasizes primary healthcare, disease prevention, and maternal-child health services, but patient choice of provider is limited, particularly in rural areas.
            </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level33Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Level 3 – Health Centre - Rural / Urban Clinic – Urban Centre (HC-UC)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
                Level 3 facility is a primary healthcare center in Papua New Guinea, providing integrated outpatient and limited inpatient services with nursing officers, community health workers, and in some cases medical officers. Level 3 hospitals are the main service delivery point for preventive, promotive, and basic curative care at the community level, receiving referrals from Level 1–2 facilities and referring more complex cases to Level 4 hospitals, while supporting public health programs under the guidance of the Papua New Guinea National Department of Health.
            </p>
             <h6 class="fw-bold">
                <b>Role</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Primary care hub for defined catchment population</li>
                    <li>Receives referrals from Level 1–2 facilities (aid posts)</li>
                    <li>Refers moderate and complex cases to Level 4 hospitals</li>
                    <li>Implements national public health and outreach programs</li>
                </ul>
            </p>
            <h6 class="fw-bold">
                <b>Clinical Services</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Bed Capacity: Typically 10–40 beds (limited inpatient capability)</li>
                    <li>
                        <strong>Core Services</strong>
                        <ul>
                            <li>General outpatient care</li>
                            <li>Maternal and child health (antenatal, delivery, postnatal)</li>
                            <li>Basic inpatient care</li>
                            <li>Management of common diseases</li>
                            <li>Immunization and public health programs</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Emergency Services</strong>
                        <ul>
                            <li>Basic emergency care</li>
                            <li>Stabilization prior to referral</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostic</strong>
                        <ul>
                            <li>Basic laboratory (e.g. malaria, hemoglobin)</li>
                            <li>Rapid diagnostic tests</li>
                            <li>No advanced imaging</li>
                        </ul>
                    </li>
                </ul>
            </p>
             <h5 class="fw-bold" style="color:#3c8dbc;">
                Papua New Guinea Government Health System
            </h5>
            <p class="text-justify">
                Papua New Guinea operates a state-led, tax-funded public health system without a unified national health insurance scheme. The system is administered by Papua New Guinea National Department of Health and delivered through a decentralized network of provincial and district health services.
            </p>
            <p class="text-justify">
                Healthcare financing is primarily derived from:
                <ul>
                    <li>General government taxation</li>
                    <li>Significant external donor support</li>
                </ul>
                Papua New Guinea does not operate parallel insurance schemes. Instead, the system is structured around public service provision with limited user fees, supplemented by private out-of-pocket payments and employer-based arrangements.
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Public Health Service Delivery System (Government & Provincial Health Authorities)
            </h5>
            <p class="text-justify">
                Papua New Guinea’s primary healthcare system is delivered through a nationwide network of public facilities managed by Provincial Health Authorities (PHAs) under the policy direction of the National Department of Health. It covers most of the population, particularly in rural and remote areas.
            </p>
            <p class="text-justify">
                The system is largely financed through government budgets, meaning services are free or low-cost at the point of care, especially for essential health services.
            </p>
            <p class="text-justify">
                Care is delivered through a tiered referral system (Level 1–6), with patients typically accessing care through primary-level facilities before being referred to higher-level hospitals.
            </p>
            <p class="text-justify">
                Public providers include:
                <ul>
                    <li>Aid Posts, Health Sub-centers, and Health Centers (primary care)</li>
                    <li>District, Provincial, and Regional / National Hospitals (secondary and tertiary care)</li>
                </ul>
                This structure emphasizes primary healthcare, disease prevention, and maternal-child health services, but patient choice of provider is limited, particularly in rural areas.
            </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level44Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Level 4 – District Hospital - Rural Health Services (DHA)</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
                Level 4 facility is a district-level general hospital in Papua New Guinea, operating under District Health Authorities (DHAs) and providing comprehensive primary and intermediate care services including general medicine, basic surgery, obstetrics, pediatrics, emergency care, and essential diagnostic services with medical officer oversight; it serves as the main referral center for Level 1–3 facilities within the district, managing moderate-complexity cases while stabilizing and referring more complex cases to Level 5 or Level 6 hospitals, and functions as a key platform for district-level clinical governance, service coordination, and implementation of national health programs under the guidance of the Papua New Guinea National Department of Health.
            </p>
             <h6 class="fw-bold">
                <b>Role</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>First-level hospital for inpatient and surgical care</li>
                    <li>Receives referrals from Level 3 health centers and lower facilities</li>
                    <li>Stabilizes and refers complex cases to Level 5 and Level 6 hospitals</li>
                    <li>Provides district-level clinical leadership and service coordination</li>
                </ul>
            </p>
            <h6 class="fw-bold">
                <b>Clinical Services</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Bed Capacity: Typically 50–150 beds</li>
                    <li>
                        <strong>Core Services</strong>
                        <ul>
                            <li>General medicine</li>
                            <li>Basic surgery</li>
                            <li>Obstetrics (including C-section in some facilities)</li>
                            <li>Pediatrics</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Emergency Services</strong>
                        <ul>
                            <li>24-hour emergency care</li>
                            <li>Trauma stabilization </li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostic</strong>
                        <ul>
                            <li>Basic laboratory</li>
                            <li>X-ray (in some facilities)</li>
                            <li>Limited imaging</li>
                        </ul>
                    </li>
                </ul>
            </p>
             <h5 class="fw-bold" style="color:#3c8dbc;">
                Papua New Guinea Government Health System
            </h5>
            <p class="text-justify">
                Papua New Guinea operates a state-led, tax-funded public health system without a unified national health insurance scheme. The system is administered by Papua New Guinea National Department of Health and delivered through a decentralized network of provincial and district health services.
            </p>
            <p class="text-justify">
                Healthcare financing is primarily derived from:
                <ul>
                    <li>General government taxation</li>
                    <li>Significant external donor support</li>
                </ul>
                Papua New Guinea does not operate parallel insurance schemes. Instead, the system is structured around public service provision with limited user fees, supplemented by private out-of-pocket payments and employer-based arrangements.
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Public Health Service Delivery System (Government & Provincial Health Authorities)
            </h5>
            <p class="text-justify">
                Papua New Guinea’s primary healthcare system is delivered through a nationwide network of public facilities managed by Provincial Health Authorities (PHAs) under the policy direction of the National Department of Health. It covers most of the population, particularly in rural and remote areas.
            </p>
            <p class="text-justify">
                The system is largely financed through government budgets, meaning services are free or low-cost at the point of care, especially for essential health services.
            </p>
            <p class="text-justify">
                Care is delivered through a tiered referral system (Level 1–6), with patients typically accessing care through primary-level facilities before being referred to higher-level hospitals.
            </p>
            <p class="text-justify">
                Public providers include:
                <ul>
                    <li>Aid Posts, Health Sub-centers, and Health Centers (primary care)</li>
                    <li>District, Provincial, and Regional / National Hospitals (secondary and tertiary care)</li>
                </ul>
                This structure emphasizes primary healthcare, disease prevention, and maternal-child health services, but patient choice of provider is limited, particularly in rural areas.
            </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level55Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Level 5 – Provincial Hospital, Health Services and Public Health Programs (PHA)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
                Level 5 facility is a provincial-level tertiary hospital in Papua New Guinea, operating under Provincial Health Authorities (PHAs) and provides advanced general and selected specialist medical, surgical, obstetric, pediatric, and diagnostic services with specialist and medical officer support. Level 5 hospitals are the primary referral center for Level 1–4 facilities in the province and surrounding areas, managing complex but not nationally referred cases while stabilizing and transferring highly specialized cases to Level 6, and is a key node for provincial clinical governance, workforce training, and implementation of national health programs and standards under the guidance of the Papua New Guinea National Department of Health.
            </p>
             <h6 class="fw-bold">
                <b>Role</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Main referral hospital at provincial level</li>
                    <li>Provides specialist services for the province</li>
                    <li>Supervises district and rural health facilities</li>
                    <li>Supports public health programs and disease surveillance</li>
                </ul>
            </p>
            <h6 class="fw-bold">
                <b>Clinical Services</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Bed Capacity: Typically 100–500 beds</li>
                    <li>
                        <strong>Clinical Services</strong>
                        <ul>
                            <li>Internal Medicine</li>
                            <li>General Surgery</li>
                            <li>Obstetrics & Gynecology</li>
                            <li>Pediatrics</li>
                            <li>Emergency services</li>
                            <li>Basic anesthesia and operative care</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Emergency & Critical Care</strong>
                        <ul>
                            <li>24-hour emergency services</li>
                            <li>Basic ICU or high-dependency care</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Surgical Capacity</strong>
                        <ul>
                            <li>General surgery</li>
                            <li>Cesarean section</li>
                            <li>Basic orthopedic procedures</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostics</strong>
                        <ul>
                            <li>X-ray and ultrasound</li>
                            <li>Laboratory services (hematology, chemistry, microbiology)</li>
                            <li>Blood transfusion services</li>
                        </ul>
                    </li>
                </ul>
            </p>
             <h5 class="fw-bold" style="color:#3c8dbc;">
                Papua New Guinea Government Health System
            </h5>
            <p class="text-justify">
                Papua New Guinea operates a state-led, tax-funded public health system without a unified national health insurance scheme. The system is administered by Papua New Guinea National Department of Health and delivered through a decentralized network of provincial and district health services.
            </p>
            <p class="text-justify">
                Healthcare financing is primarily derived from:
                <ul>
                    <li>General government taxation</li>
                    <li>Significant external donor support</li>
                </ul>
                Papua New Guinea does not operate parallel insurance schemes. Instead, the system is structured around public service provision with limited user fees, supplemented by private out-of-pocket payments and employer-based arrangements.
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Public Health Service Delivery System (Government & Provincial Health Authorities)
            </h5>
            <p class="text-justify">
                Papua New Guinea’s primary healthcare system is delivered through a nationwide network of public facilities managed by Provincial Health Authorities (PHAs) under the policy direction of the National Department of Health. It covers most of the population, particularly in rural and remote areas.
            </p>
            <p class="text-justify">
                The system is largely financed through government budgets, meaning services are free or low-cost at the point of care, especially for essential health services.
            </p>
            <p class="text-justify">
                Care is delivered through a tiered referral system (Level 1–6), with patients typically accessing care through primary-level facilities before being referred to higher-level hospitals.
            </p>
            <p class="text-justify">
                Public providers include:
                <ul>
                    <li>Aid Posts, Health Sub-centers, and Health Centers (primary care)</li>
                    <li>District, Provincial, and Regional / National Hospitals (secondary and tertiary care)</li>
                </ul>
                This structure emphasizes primary healthcare, disease prevention, and maternal-child health services, but patient choice of provider is limited, particularly in rural areas.
            </p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:900px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Level 6 – National Referral Specialist Tertiary and Teaching Hospital - Health Services (NHA)</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
               Level 6 facility is the highest tier of healthcare service in Papua New Guinea, and is the national referral tertiary hospital under the Papua New Guinea National Department of Health (MDOH), providing comprehensive advanced medical, surgical, diagnostic, and subspecialty services supported by highly specialized workforce and national-level infrastructure. Level 6 hospitals are the ultimate referral destination for all lower-level facilities (Levels 1–5), managing the most complex cases while functions as the central hub for clinical governance, specialist training and education, research, and implementation of national health policies, as well as playing a leading role in disaster response coordination, public health surveillance, and overall health system development (e.g. Port Moresby General Hospital).
            </p>
             <h6 class="fw-bold">
                <b>Role</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>National apex referral center for all complex and high-acuity cases</li>
                    <li>Provides advanced specialist and subspecialist care not available elsewhere</li>
                    <li>Serves as a teaching and training hospital for doctors, nurses, and allied health professionals</li>
                    <li>Leads national disease control, outbreak response, and health policy implementation</li>
                    <li>Provides technical supervision and clinical governance to all lower-level facilities</li>
                </ul>
            </p>
            <h6 class="fw-bold">
                <b>Clinical Services</b>
            </h6>
            <p class="text-justify">
                <ul>
                    <li>Bed Capacity: Typically ≥ 500 beds (largest in the country)</li>
                    <li>
                        <strong>Comprehensive Clinical Specialties</strong>
                        <ul>
                            <li>Internal Medicine (with subspecialties where available)</li>
                            <li>General and specialized surgery</li>
                            <li>Orthopedics and trauma</li>
                            <li>Obstetrics & Gynecology (high-risk care)</li>
                            <li>Pediatrics (including neonatal care)</li>
                            <li>Anesthesiology and critical care</li>
                            <li>Emergency medicine</li>
                            <li>Psychiatry</li>
                            <li>ENT, Ophthalmology, Urology (limited subspecialty depth compared to high-income countries)</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Advanced Emergency & Critical Care</strong>
                        <ul>
                            <li>24-hour emergency department</li>
                            <li>National-level trauma and referral coordination</li>
                            <li>Intensive Care Units (ICU)</li>
                            <li>Neonatal and pediatric critical care (limited capacity)</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Surgical & Interventional Capacity</strong>
                        <ul>
                            <li>Major elective and emergency surgeries</li>
                            <li>Complex trauma and surgical cases</li>
                            <li>Some advanced procedures (dependent on workforce and resources)</li>
                        </ul>
                    </li>
                    <li class="mt-2">
                        <strong>Diagnostic & Therapeutic Infrastructure</strong>
                        <ul>
                            <li>Imaging</li>
                            <ul>
                                <li>X-ray</li>
                                <li>Ultrasound</li>
                                <li>CT scan (available at national level)</li>
                                <li>MRI (limited availability)</li>
                                <li>Laboratory</li>
                                <ul>
                                    <li>Full clinical pathology</li>
                                    <li>Microbiology</li>
                                </ul>
                                <li>Blood bank services</li>
                                <ul>
                                    <li>Limited oncology and renal services (developing capacity)</li>
                                </ul>
                            </ul>
                        </ul>
                    </li>
                </ul>
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Papua New Guinea Government Health System
            </h5>
            <p class="text-justify">
                Papua New Guinea operates a state-led, tax-funded public health system without a unified national health insurance scheme. The system is administered by Papua New Guinea National Department of Health and delivered through a decentralized network of provincial and district health services.
            </p>
            <p class="text-justify">
                Healthcare financing is primarily derived from:
                <ul>
                    <li>General government taxation</li>
                    <li>Significant external donor support</li>
                </ul>
                Papua New Guinea does not operate parallel insurance schemes. Instead, the system is structured around public service provision with limited user fees, supplemented by private out-of-pocket payments and employer-based arrangements.
            </p>
            <h5 class="fw-bold" style="color:#3c8dbc;">
                Public Health Service Delivery System (Government & Provincial Health Authorities)
            </h5>
            <p class="text-justify">
                Papua New Guinea’s primary healthcare system is delivered through a nationwide network of public facilities managed by Provincial Health Authorities (PHAs) under the policy direction of the National Department of Health. It covers most of the population, particularly in rural and remote areas.
            </p>
            <p class="text-justify">
                The system is largely financed through government budgets, meaning services are free or low-cost at the point of care, especially for essential health services.
            </p>
            <p class="text-justify">
                Care is delivered through a tiered referral system (Level 1–6), with patients typically accessing care through primary-level facilities before being referred to higher-level hospitals.
            </p>
            <p class="text-justify">
                Public providers include:
                <ul>
                    <li>Aid Posts, Health Sub-centers, and Health Centers (primary care)</li>
                    <li>District, Provincial, and Regional / National Hospitals (secondary and tertiary care)</li>
                </ul>
                This structure emphasizes primary healthcare, disease prevention, and maternal-child health services, but patient choice of provider is limited, particularly in rural areas.
            </p>
      </div>
    </div>
  </div>
</div>

@endsection

@push('service')

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const provinceSelect = document.querySelector('#provinceSelect .select-input');
    const provinceDropdown = document.querySelector('#provinceSelect .select-dropdown');
    const provinceSearch = document.getElementById('provinceSearch');
    const provinceSearchInput = document.getElementById('provinceSearchInput');

    // buka/tutup dropdown
    provinceSelect.addEventListener('click', () => {
        provinceDropdown.classList.toggle('show');
        const panel = document.querySelector('.leaflet-control-custom');

        if (provinceDropdown.classList.contains('show')) {

            const dropdownHeight =
                provinceDropdown.scrollHeight;

            panel.style.height =
                (420 + dropdownHeight) + 'px';

        } else {

            panel.style.height = '420px';
        }
    });

    // tutup saat klik luar
    document.addEventListener('click', (e) => {
        if (!document.getElementById('provinceSelect').contains(e.target)) {
            provinceDropdown.classList.remove('show');
        }
    });

    // filter pencarian
    provinceSearchInput.addEventListener('keyup', function () {
        const keyword = this.value.toLowerCase();

        document.querySelectorAll('#provinceList li').forEach(li => {
            const text = li.textContent.toLowerCase();

            li.style.display = text.includes(keyword)
                ? ''
                : 'none';
        });
    });

    // update text input ketika checkbox dipilih
    document.addEventListener('change', function(e) {

        if (e.target.classList.contains('province-checkbox')) {

            const selected = [...document.querySelectorAll('.province-checkbox:checked')]
                .map(cb => cb.parentElement.textContent.trim());

            if (selected.length === 0) {
                provinceSearch.value = '';
                provinceSearch.placeholder = '🔍 Select Province';
            } else if (selected.length <= 2) {
                provinceSearch.value = selected.join(', ');
            } else {
                provinceSearch.value = selected.length + ' Province';
            }
        }
    });

});
</script>

<script>
    // --- Map Initialization ---
    const map = L.map('map').setView([-6.80188562253168, 144.0733101155011], 5);

    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors', maxZoom: 19
    }).addTo(map);

    const satelliteLayer = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        { attribution: 'Tiles © Esri', maxZoom: 19 }
    );

    L.control.layers(
        { "Street Map": osmLayer, "Satellite Map": satelliteLayer },
        null,
        { position: 'topleft' } // posisi kiri atas
    ).addTo(map);

    L.control.fullscreen({
        position: 'topleft' // tetap di kiri atas
    }).addTo(map);

    const style = document.createElement('style');
    style.textContent = `
        .leaflet-top.leaflet-left .leaflet-control-layers {
            margin-top: 5px !important;
        }
        .leaflet-top.leaflet-left .leaflet-control-zoom {
            margin-top: 10px !important;
        }
        `;
    document.head.appendChild(style);

    // --- Global States ---
    let airportMarkers = L.featureGroup().addTo(map);
    let hospitalMarkers = L.featureGroup().addTo(map);
    let policeMarkers = L.featureGroup().addTo(map);
    let embassyMarkers = L.featureGroup().addTo(map);
    let radiusCircle = null;
    let radiusPinMarker = null;
    let lastClickedLocation = null;
    let drawnPolygonGeoJSON = null;
    let totalHospitals = 0;
    let totalAirports = 0;
    let totalPolice = 0;
    let totalEmbassies = 0;

    // --- Leaflet Draw ---
    const drawnItems = new L.FeatureGroup().addTo(map);
    const drawControl = new L.Control.Draw({
        draw: {
            polygon: { allowIntersection: false, shapeOptions: { color: '#0000FF', fillOpacity: 0.2 } },
            polyline: false, rectangle: false, circle: false, marker: false, circlemarker: false
        },
        edit: { featureGroup: drawnItems }
    });
    map.addControl(drawControl);

    map.on(L.Draw.Event.CREATED, async e => {
        drawnItems.clearLayers();
        drawnItems.addLayer(e.layer);

        drawnPolygonGeoJSON = e.layer.toGeoJSON();

        // console.log('Polygon Created', drawnPolygonGeoJSON);

        await refreshCurrentFilters();
    });
    map.on(L.Draw.Event.EDITED, async e => {

        e.layers.eachLayer(layer => {
            drawnPolygonGeoJSON = layer.toGeoJSON();
        });

        // console.log('Polygon Edited', drawnPolygonGeoJSON);

        await refreshCurrentFilters();
    });
    map.on(L.Draw.Event.DELETED, async () => {

        drawnItems.clearLayers();

        drawnPolygonGeoJSON = null;

        // console.log('Polygon Deleted');

        await refreshCurrentFilters();
    });

    // --- Update Radius ---
    function updateRadiusCircleAndPin(radius = 0) {
        if (radiusCircle) { map.removeLayer(radiusCircle); radiusCircle = null; }
        if (radiusPinMarker) { map.removeLayer(radiusPinMarker); radiusPinMarker = null; }

        if (radius > 0 && lastClickedLocation) {
            radiusCircle = L.circle(lastClickedLocation, {
                color: 'red', fillColor: '#f03', fillOpacity: 0.3, radius: radius * 1000
            }).addTo(map);
            const redIcon = L.icon({
                iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                iconSize: [25, 41], iconAnchor: [12, 41], popupAnchor: [1, -34], shadowSize: [41, 41]
            });
            radiusPinMarker = L.marker(lastClickedLocation, { icon: redIcon }).addTo(map);
        }
    }

    map.on('click', e => {
        lastClickedLocation = { lat: e.latlng.lat, lng: e.latlng.lng };
        const radius = parseInt(document.querySelector('#radiusRangeMap')?.value || 0);
        document.querySelector('#radiusValueMap').textContent = radius;
        updateRadiusCircleAndPin(radius);
    });

    // --- Fetch Data ---
    async function fetchData(url, filters = {}) {
        const params = new URLSearchParams();
        Object.entries(filters).forEach(([k, v]) => {
            if (Array.isArray(v)) v.forEach(x => params.append(`${k}[]`, x));
            else if (v !== '' && v != null) params.append(k, v);
        });
        if (drawnPolygonGeoJSON) params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));
        //  console.log(url + '?' + params.toString());

        try {
            const res = await fetch(`${url}?${params.toString()}`);
            return res.ok ? await res.json() : [];
        } catch (e) {
            console.error(`Error fetching ${url}:`, e);
            return [];
        }
    }

    // --- Add Markers ---
    function addMarkers(data, group, defaultIconUrl) {
        group.clearLayers();
        data.forEach(item => {
            if (!item || !item.latitude || !item.longitude) return;

            let iconSize = [24, 24];
            let iconAnchor = [12, 24];

            // Police icon lebih kecil
            if (item.name_police) {
                iconSize = [12, 12];
                iconAnchor = [6, 6];
            }

            const icon = L.icon({
                iconUrl: item.icon || defaultIconUrl || 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-icon.png',
                iconSize: iconSize,
                iconAnchor: iconAnchor,
                popupAnchor: [0, -20]
            });

            const marker = L.marker([item.latitude, item.longitude], { icon }).addTo(group);

            let itemName = '', detailUrl = '', popupContent = '';

            if (item.airport_name) {
                itemName = item.airport_name;
                detailUrl = `/airports/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Classification:</strong> ${item.category || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.province_name ? ', ' + item.province_name : ''}, Papua New Guinea <br>
                    <strong>Website:</strong> ${item.website || 'N/A'} <br>
                `;
            } else if (item.name) {
                itemName = item.name;
                detailUrl = `/hospitals/${item.id}`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Global Classification:</strong> ${item.facility_category || 'N/A'}<br>
                    <strong>Country Classification:</strong> ${item.facility_level || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Papua New Guinea <br>
                `;
            } else if (item.name_police) {
                itemName = item.name_police;
                detailUrl = `/police/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Category:</strong> ${item.category || 'N/A'}<br>
                    <strong>Address:</strong>
                        ${item.location || 'N/A'}
                        ${item.province_name ? ', ' + item.province_name : ''}, Papua New Guinea <br>
                    <strong>Phone:</strong> ${item.telephone || 'N/A'}<br>
                    <strong>Fax:</strong> ${item.fax || 'N/A'}<br>
                    <strong>Email:</strong> ${item.email || 'N/A'}<br>
                    <strong>Website:</strong> ${item.website || 'N/A'}<br>
                `;
            }
            else if (item.name_embassiees) {
                itemName = item.name_embassiees;
                detailUrl = `/embassiees/${item.id}/detail`;
                popupContent = `
                    <h5 style="border-bottom:1px solid #cccccc;">${itemName}</h5>
                    <strong>Address:</strong>
                        ${item.address || 'N/A'}
                        ${item.provinces_region ? ', ' + item.provinces_region : ''}, Papua New Guinea <br>
                    <strong>Phone:</strong> ${item.telephone || 'N/A'}<br>
                    <strong>Fax:</strong> ${item.fax || 'N/A'}<br>
                    <strong>Email:</strong> ${item.email || 'N/A'}<br>
                    <strong>Website:</strong> ${item.website || 'N/A'}<br>
                `;
            }

            if (item.id && detailUrl)
                popupContent += `<a href="${detailUrl}" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>`;

            marker.bindPopup(popupContent);
        });
    }

    // --- Apply Filters ---
    async function applyFiltersWithMapControl(
        facilities = [],
        hospitalLevels = [],
        airportClasses = [],
        provinces = [],
        radius = 0,
        airportName = '',
        hospitalName = ''
    ) {
        let common = { provinces };
        if (radius > 0 && lastClickedLocation) {
            common.radius = radius;
            common.center_lat = lastClickedLocation.lat;
            common.center_lng = lastClickedLocation.lng;
        }

        totalHospitals = 0;
        totalAirports = 0;
        totalPolice = 0;
        totalEmbassies = 0;

        // jika tidak ada checkbox dipilih => tampilkan semua
        const showAllFacilities = facilities.length === 0;

        const showHospital =
            showAllFacilities || facilities.includes('hospital');

        const showAirport =
            showAllFacilities || facilities.includes('airport');

        const showPolice =
            showAllFacilities || facilities.includes('police');

        const showEmbassy =
            showAllFacilities || facilities.includes('embassy');

        // === HOSPITALS ===
        if (showHospital) {
             const result = await fetchData('/api/hospital', {
                ...common,
                name: hospitalName,
                category: hospitalLevels
            });

            addMarkers(result.hospitals, hospitalMarkers, null);

            totalHospitals = result.hospitals.length;
        } else {
            hospitalMarkers.clearLayers();
        }

        // === AIRPORTS ===
       if (showAirport) {

            const airportResponse = await fetchData('/api/airports', {
                ...common,
                name: airportName
            });

            const airports = Array.isArray(airportResponse)
                    ? airportResponse
                    : airportResponse.airports || [];
            const categoryCounts = airportResponse.categoryCounts || {};

            const filteredAirports = airports.filter(a => {

                if (airportClasses.length === 0) {
                    return true;
                }

                if (!a.category) {
                    return false;
                }

                const dbCategories = a.category
                    .split(',')
                    .map(c => c.trim().toLowerCase());

                return airportClasses.some(sel =>
                    dbCategories.includes(sel.toLowerCase())
                );
            });

            addMarkers(
                filteredAirports,
                airportMarkers,
                'https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png'
            );

            totalAirports = filteredAirports.length;
        }else {
            airportMarkers.clearLayers();
        }

        // === POLICE ===
       if (showPolice) {

            const result = await fetchData('/api/polices', {
                ...common
            });

            const police = result.polices || [];
            const categoryCounts = result.categoryCounts || {};

            addMarkers(
                police,
                policeMarkers,
                null
            );

            totalPolice = police.length;

            Object.keys(categoryCounts).forEach(cat => {

                const id = cat.replace(/[^a-zA-Z0-9]/g, '-');

                const el = document.getElementById(`count-${id}`);

                if (el) {
                    el.textContent = categoryCounts[cat];
                }
            });
        } else {
            policeMarkers.clearLayers();
        }

        // === EMBASSY ===
        if (showEmbassy) {

            const embassies = await fetchData('/api/embassy', {
                ...common
            });

            addMarkers(
                embassies,
                embassyMarkers,
                '/images/embassy-icon-new.png'
            );

            totalEmbassies = embassies.length;

        } else {
            embassyMarkers.clearLayers();
        }

        updateRadiusCircleAndPin(radius);
        updateTotalCountDisplay();
    }

    function updateTotalCountDisplay() {
        document.getElementById('airportCount').textContent = totalAirports;
        document.getElementById('hospitalCount').textContent = totalHospitals;
        document.getElementById('policeCount').textContent = totalPolice;
        document.getElementById('embassyCount').textContent = totalEmbassies;

        const el = document.getElementById('totalCountDisplay');
    }

    // === COMBINED PANEL ===
    const CombinedPanel = L.Control.extend({
        options: { position: 'topright' },
        onAdd: function () {
            const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            Object.assign(div.style, {
                background: 'white',
                borderRadius: '8px',
                boxShadow: '0 2px 6px rgba(0,0,0,0.2)',
                minWidth: '260px',
                maxHeight: '85vh',
                overflowY: 'auto'
            });

            div.innerHTML = `
                <button style="background:#007bff;color:white;border:none;width:100%;padding:8px;">Filter & Radius</button>
                <div id="filterPanel" style="
                    padding:10px;
                    display:flex;
                    flex-direction:column;
                    height:100%;
                ">
                    <strong>Radius: <span id="radiusValueMap">0</span> km</strong>
                    <input type="range" id="radiusRangeMap" min="0" max="500" value="0" style="width:100%;margin-bottom:6px;">
                    <div style="display:flex;gap:5px;">
                        <button id="applyRadiusMap" class="btn btn-sm btn-primary flex-fill">Apply</button>
                        <button id="resetRadiusMap" class="btn btn-sm btn-danger flex-fill">Reset</button>
                    </div>
                    <hr>
                    <strong>Facilities</strong>
                    <div class="form-check">
                        <input class="form-check-input facility-checkbox" type="checkbox" value="hospital" id="facilityHospital">
                        <label class="form-check-label" for="facilityHospital">
                            Medical (<span id="hospitalCount">0</span>)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input facility-checkbox" type="checkbox" value="airport" id="facilityAirport">
                        <label class="form-check-label" for="facilityAirport">
                            Aviation (<span id="airportCount">0</span>)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input facility-checkbox" type="checkbox" value="police" id="facilityPolice">
                        <label class="form-check-label" for="facilityPolice">
                            Police (<span id="policeCount">0</span>)
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input facility-checkbox" type="checkbox" value="embassy" id="facilityEmbassy">
                        <label class="form-check-label" for="facilityEmbassy">
                            Embassies (<span id="embassyCount">0</span>)
                        </label>
                    </div>

                    <hr>
                    <div class="filter-box" id="provinceSelect">
                        <label class="filter-label">
                            Province
                        </label>

                        <div class="select-input">
                            <input
                                type="text"
                                id="provinceSearch"
                                placeholder="🔍 Select Province"
                                readonly
                            >
                            <i class="bi bi-chevron-down"></i>
                        </div>

                        <div class="select-dropdown">
                            <input
                                type="text"
                                class="dropdown-search"
                                id="provinceSearchInput"
                                placeholder="Search Province..."
                            >

                            <ul id="provinceList">
                                @foreach($provinces as $province)
                                <li>
                                    <label>
                                        <input
                                            type="checkbox"
                                            class="province-checkbox"
                                            value="{{ $province->id }}"
                                        >
                                        {{ $province->provinces_region }}
                                    </label>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <hr>
                    <button id="resetMapFilter"
                            class="btn btn-sm btn-secondary w-100"
                            style="margin-top:auto;">
                        Reset All
                    </button>
                    <div id="totalCountDisplay" style="margin-top:8px;text-align:center;font-size:13px;"></div>
                </div>`;
            L.DomEvent.disableClickPropagation(div);
            return div;
        }
    });
    map.addControl(new CombinedPanel());

    // === INIT SELECT2 ===
    setTimeout(() => {
        if (typeof $ !== 'undefined' && $.fn.select2) {
            $('.select-search-airport').select2({ placeholder: 'Select Airport', width: '100%' });
            $('.select-search-hospital').select2({ placeholder: 'Select Hospital', width: '100%' });
        }
    }, 300);

    function getCurrentFiltersFromUI() {
        const facilities = [...document.querySelectorAll('.facility-checkbox:checked')].map(el => el.value);
        const hLevels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
        const aClasses = [...document.querySelectorAll('input[name="airportClass"]:checked')].map(e => e.value);
        const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
        const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);
        // untuk select2, .value akan tetap bekerja because Select2 keeps value in the <select>
        const airportName = document.getElementById('airport_name_map')?.value || '';
        const hospitalName = document.getElementById('hospital_name_map')?.value || '';
        return { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName };
    }

    async function refreshCurrentFilters() {
        const {
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        } = getCurrentFiltersFromUI();

        await applyFiltersWithMapControl(
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        );
    }

    // === Event Logic ===
    document.addEventListener('change', async e => {
        const facilities = [...document.querySelectorAll('.facility-checkbox:checked')].map(el => el.value);
        const hLevels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
        const aClasses = [...document.querySelectorAll('input[name="airportClass"]:checked')].map(e => e.value);
        const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
        const radius = parseInt(document.getElementById('radiusRangeMap').value || 0);
        const airportName = document.getElementById('airport_name_map')?.value || '';
        const hospitalName = document.getElementById('hospital_name_map')?.value || '';

        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
    });

    // === INPUT: update tampilan radius saat slider digeser (live) ===
document.addEventListener('input', (e) => {
    if (e.target && e.target.id === 'radiusRangeMap') {
        const r = parseInt(e.target.value || 0);
        const el = document.getElementById('radiusValueMap');
        if (el) el.textContent = r;
        // hanya update tampilan lingkaran saja (belum apply ke filter)
        updateRadiusCircleAndPin(r);
    }
});

// === CLICK: apply / reset radius dan reset all ===
document.addEventListener('click', async (e) => {
    if (!e.target) return;

    // APPLY RADIUS => ambil filter sekarang lalu panggil applyFiltersWithMapControl dengan radius
    if (e.target.id === 'applyRadiusMap') {
        const {
            facilities,
            hLevels,
            aClasses,
            provs,
            radius,
            airportName,
            hospitalName
        } = getCurrentFiltersFromUI();
        // pastikan lastClickedLocation ada jika radius > 0
        if (radius > 0 && !lastClickedLocation) {
            alert('Tentukan titik di peta terlebih dahulu dengan klik peta untuk menggunakan filter radius.');
            return;
        }
        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        return;
    }

    // RESET RADIUS (hanya reset radius visual & reapply tanpa radius)
    if (e.target.id === 'resetRadiusMap') {
        // reset slider & tampilan
        const rEl = document.getElementById('radiusRangeMap');
        const rValEl = document.getElementById('radiusValueMap');
        if (rEl) rEl.value = 0;
        if (rValEl) rValEl.textContent = '0';

        // hapus circle & pin
        if (radiusCircle) { map.removeLayer(radiusCircle); radiusCircle = null; }
        if (radiusPinMarker) { map.removeLayer(radiusPinMarker); radiusPinMarker = null; }
        lastClickedLocation = null;

        // apply ulang tanpa radius (tetap simpan filter lain)
        const { facilities, hLevels, aClasses, provs, airportName, hospitalName } = getCurrentFiltersFromUI();
        await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, 0, airportName, hospitalName);
        return;
    }

    // RESET ALL FILTERS (tombol Reset All) -> gunakan handler yang sudah komprehensif
    if (e.target.id === 'resetMapFilter') {
        // 1) UI reset
        document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(cb => {
            cb.checked = false;
        });

        // reset province dropdown text
        const provinceSearch = document.getElementById('provinceSearch');
        if (provinceSearch) {
            provinceSearch.value = '';
        }

        // reset search keyword pada dropdown
        const provinceSearchInput = document.getElementById('provinceSearchInput');
        if (provinceSearchInput) {
            provinceSearchInput.value = '';
        }

        // tampilkan kembali semua province
        document.querySelectorAll('#provinceList li').forEach(li => {
            li.style.display = '';
        });

        // sembunyikan sub-panels
        const af = document.getElementById('airportFilter');
        const hf = document.getElementById('hospitalFilter');
        if (af) af.style.display = 'none';
        if (hf) hf.style.display = 'none';

        // 2) Reset Select2 (jika ada)
        if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
            $('.select-search-airport').each(function () { $(this).val(null).trigger('change'); });
            $('.select-search-hospital').each(function () { $(this).val(null).trigger('change'); });
        } else {
            const airportSel = document.getElementById('airport_name_map');
            const hospitalSel = document.getElementById('hospital_name_map');
            if (airportSel) airportSel.value = '';
            if (hospitalSel) hospitalSel.value = '';
        }

        // 3) Reset radius visual
        const radiusRange = document.getElementById('radiusRangeMap');
        const radiusValue = document.getElementById('radiusValueMap');
        if (radiusRange) radiusRange.value = 0;
        if (radiusValue) radiusValue.textContent = '0';
        if (radiusCircle) { map.removeLayer(radiusCircle); radiusCircle = null; }
        if (radiusPinMarker) { map.removeLayer(radiusPinMarker); radiusPinMarker = null; }
        lastClickedLocation = null;

        // 4) Remove drawn polygon and layers
        if (drawnItems) drawnItems.clearLayers();
        drawnPolygonGeoJSON = null;

        // 5) Clear markers and counters
        if (airportMarkers) airportMarkers.clearLayers();
        if (hospitalMarkers) hospitalMarkers.clearLayers();
        if (policeMarkers) policeMarkers.clearLayers();
        if (embassyMarkers) embassyMarkers.clearLayers();
        totalAirports = 0;
        totalHospitals = 0;
        totalPolice = 0;
        totalEmbassies = 0;
        updateTotalCountDisplay();

        // 6) Re-fetch semua data
        await applyFiltersWithMapControl(
            [],
            [],
            [],
            [],
            0,
            '',
            ''
        );

        e.stopPropagation();
        e.preventDefault();
        return;
    }
});

// === LISTEN TO CHANGE on filter inputs (kategori/provinsi/select nama) ===
// Ini memastikan ketika user change checkbox / select2, filter langsung ter-apply
function bindFilterChangeAutoApply() {
    // checkbox change
    document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(el => {
        el.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    });

    // select2 change (nama)
    // if Select2 is used, listen with jQuery; otherwise plain change event above covers plain <select>
    if (typeof $ !== 'undefined' && $.fn && $.fn.select2) {
        $(document).on('change', '#airport_name_map, #hospital_name_map', async function () {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    } else {
        document.getElementById('airport_name_map')?.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
        document.getElementById('hospital_name_map')?.addEventListener('change', async () => {
            const { facilities, hLevels, aClasses, provs, radius, airportName, hospitalName } = getCurrentFiltersFromUI();
            await applyFiltersWithMapControl(facilities, hLevels, aClasses, provs, radius, airportName, hospitalName);
        });
    }
}

// call binding after panel is rendered
setTimeout(bindFilterChangeAutoApply, 350);

    // --- Initial Load ---
    refreshCurrentFilters();
</script>

@endpush
