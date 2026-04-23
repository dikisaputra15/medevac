@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.css" />

<style>
    #map {
        height: 600px;
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

     .leaflet-routing-container-hide .leaflet-routing-collapse-btn
    {
        left: 8px;
        top: 8px;
    }

    .leaflet-control-container .leaflet-routing-container-hide {
        width: 48px;
        height: 48px;
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
</style>

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex flex-column gap-1">
            <h2 class="fw-bold">{{ $hospital->name }}</h2>
            <span class="fw-bold"><b>Global Classification:</b> {{ $hospital->facility_category }} | <b>Country Classification:</b> Level {{ $hospital->facility_level }}</span>
        </div>

        <div class="d-flex gap-2 ms-auto">

            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-medical-facility-white.png') }}" style="width: 18px; height: 24px;">
                <small>Clinical</small>
            </a>

            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
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

    <div class="card mb-4 position-relative">
        <div class="card-body" style="padding:0 7px;">
            <small><i>Last Updated {{ $hospital->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('hospitaldata.edit', $hospital->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-general-info.png') }}" style="width: 24px; height: 24px;"> General Medical Facility Info</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Facility Level:</strong> {{ $hospital->facility_level }}
                    </p>
                    <p>
                        <strong>Status:</strong> {{ $hospital->status }}
                    </p>
                    <p>
                        <strong>Number Of Beds:</strong> {{ $hospital->number_of_beds }}
                    </p>
                    <p>
                        <strong>Population Catchment:</strong> {{ $hospital->population_catchment }}
                    </p>
                    <p>
                        <strong>Ownership:</strong> {{ $hospital->ownership }}
                    </p>
                    <p>
                        <strong>Hours Of Operation:</strong><br>
                        <?php echo $hospital->hrs_of_operation; ?>
                    </p>
                    <p>
                        <strong>Note:</strong>
                        <?php echo $hospital->others; ?>
                    </p>
                    <p>
                        <strong>Medical Services Info:</strong> <?php echo $hospital->other_medical_info; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-location.png') }}" style="width: 18px; height: 24px;"> Location</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Address:</strong>
                        {{ $hospital->address }},
                        {{ $province->provinces_region }}, Papua New Guinea
                    </p>
                    <p>
                        <strong>Latitude:</strong> {{ $hospital->latitude }}
                    </p>
                    <p>
                        <strong>Longitude:</strong> {{ $hospital->longitude }}
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/contact-icon.png') }}" style="width: 24px; height: 24px;"> Contact Details</div>
                <div class="card-body overflow-auto">
                    <p>
                        <strong>Telephone:</strong> <?php echo $hospital->telephone; ?>
                    </p>
                    <p>
                        <strong>Fax:</strong> <?php echo $hospital->fax; ?>
                    </p>
                    <p>
                        <strong>Email:</strong> <?php echo $hospital->email; ?>
                    </p>
                    <p>
                        <strong>Website:</strong> <?php echo $hospital->website; ?>
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-nearest-accomodation.png') }}" style="width: 24px; height: 18px;">  Nearest Accommodation</div>
                <div class="card-body overflow-auto">
                    <?php echo $hospital->nearest_accommodation; ?>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="card">

             <div class="classification" style="flex-direction: column; width:100%;">
                      <div class="class-header class-medical-classification">Medical Facility Classification</div>
                      <div class="classification">
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

                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const latitude = {{ $hospital->latitude }};
    const longitude = {{ $hospital->longitude }};
    const embassyName = '{{ $hospital->name }}';

    const map = L.map('map', {
        fullscreenControl: true
    }).setView([latitude, longitude], 17);

    // --- Define Tile Layers ---
    // 1. Street Map (OpenStreetMap)
    const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 18 // OSM generally goes up to zoom level 22
    });

    // 2. Satellite Map (Esri World Imagery) - Recommended, no API key needed
    const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        attribution: 'Tiles &copy; Esri &mdash; Source: Esri',
        maxZoom: 18 // Esri World Imagery also typically goes up to zoom level 22
    });

    // Add the satellite layer to the map by default
    satelliteLayer.addTo(map);

    // --- Add Layer Control ---
    // Define the base layers that the user can switch between
   const baseLayers = {
        "Satelit Map": satelliteLayer,
        "Street Map": osmLayer
    };

    // Add the layer control to the map. This will appear in the top-right corner.
    L.control.layers(baseLayers).addTo(map);

    // Add a marker at the embassy's location
    L.marker([latitude, longitude])
        .addTo(map)
        .bindPopup(embassyName) // Display the embassy's name when the marker is clicked
        .openPopup(); // Automatically open the popup when the map loads
</script>
@endpush
