@extends('layouts.master')

@section('title','Hospitals')
@section('page-title', 'Papua New Guinea Medical Facility')

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
    .total-hospital {
        background: white;
        padding: 8px 12px;
        border-radius: 8px;
        box-shadow: 0 0 6px rgba(0,0,0,0.2);
        font-weight: bold;
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

</style>
@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-end p-3" style="background-color: #dfeaf1;">

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

    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center gap-3">

        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-link p-0 fw-bold text-decoration-underline text-dark" data-bs-toggle="modal" data-bs-target="#disclaimerModal">
                <i class="bi bi-info-circle text-primary fs-5"></i>
                Disclaimer
            </button>
        </div>

        <div class="d-flex align-items-end gap-3">
            <div style="margin-right:20px;">
                <span class="fw-bold pb-2 d-inline-block">Classification:</span>
            </div>
            <!-- Classification -->
            <div class="classification" style="flex-direction: column; width:100%;">
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
        </div>

        </div>
    </div>

</div>


<div class="modal fade" id="disclaimerModal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="disclaimerLabel">Disclaimer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="p-modal">Every attempt has been made to ensure the completeness and accuracy of the most updated information and data available. Clients are advised, however, that provided information, and data is subject to change.</p>
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

    <div id="map"></div>

</div>


@endsection

@push('service')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.fullscreen/1.6.0/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// === Inisialisasi Peta ===
const map = L.map('map').setView([-4.245820574165665, 122.16203857061076], 5);

// === Base Layers ===
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
    { position: 'topleft' }
).addTo(map);

L.control.fullscreen({ position: 'topleft' }).addTo(map);

// === Styling posisi kontrol ===
const style = document.createElement('style');
style.textContent = `
.leaflet-top.leaflet-left .leaflet-control-layers { margin-top: 5px !important; }
.leaflet-top.leaflet-left .leaflet-control-zoom { margin-top: 10px !important; }
`;
document.head.appendChild(style);

// === Variabel Global ===
let hospitalMarkers = L.featureGroup().addTo(map);
let radiusCircle = null;
let radiusPinMarker = null;
let lastClickedLocation = null;
let drawnPolygonGeoJSON = null;

// === Leaflet Draw ===
const drawnItems = new L.FeatureGroup().addTo(map);
const drawControl = new L.Control.Draw({
    draw: {
        polygon: { allowIntersection: false, shapeOptions: { color: '#ff6600', fillColor: '#ff6600', fillOpacity: 0.2 } },
        polyline: false, rectangle: false, circle: false, marker: false, circlemarker: false
    },
    edit: { featureGroup: drawnItems }
});
map.addControl(drawControl);

// === Event Polygon ===
map.on(L.Draw.Event.CREATED, e => {
    drawnItems.clearLayers();
    drawnItems.addLayer(e.layer);
    drawnPolygonGeoJSON = e.layer.toGeoJSON();
    applyHospitalFilters();
});

map.on(L.Draw.Event.EDITED, e => {
    e.layers.eachLayer(layer => drawnPolygonGeoJSON = layer.toGeoJSON());
    applyHospitalFilters();
});

map.on(L.Draw.Event.DELETED, () => {
    drawnItems.clearLayers();
    drawnPolygonGeoJSON = null;
    applyHospitalFilters();
});

// === Radius Circle ===
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
    const radius = parseInt(document.querySelector('#radiusRangeMap').value || 0);
    document.querySelector('#radiusValueMap').textContent = radius;
    updateRadiusCircleAndPin(radius);
    applyHospitalFilters();
});

// === Fetch Data Hospital ===
async function fetchHospitalData(filters = {}) {
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([k, v]) => {
        if (Array.isArray(v)) v.forEach(x => params.append(`${k}[]`, x));
        else if (v !== '' && v != null) params.append(k, v);
    });
    if (drawnPolygonGeoJSON) params.append('polygon', JSON.stringify(drawnPolygonGeoJSON));

    try {
        const res = await fetch(`/api/hospital?${params.toString()}`);
        return res.ok ? await res.json() : [];
    } catch (e) {
        console.error('Error fetching hospital data:', e);
        return [];
    }
}

// === Tambah Marker Hospital ===
function addHospitalMarkers(data) {
    hospitalMarkers.clearLayers();
    data.forEach(h => {
        if (!h.latitude || !h.longitude) return;

        const icon = L.icon({
            iconUrl: h.icon || 'https://unpkg.com/leaflet/dist/images/marker-icon.png',
            iconSize: [24, 24], iconAnchor: [12, 24], popupAnchor: [0, -20]
        });

        const marker = L.marker([h.latitude, h.longitude], { icon }).addTo(hospitalMarkers);

        marker.bindPopup(`
            <h5 style="border-bottom:1px solid #ccc;">${h.name || 'N/A'}</h5>
            <strong>Global Classification:</strong> ${h.facility_category || 'N/A'}<br>
            <strong>Country Classification:</strong> ${h.facility_level || 'N/A'}<br>
            <strong>Address:</strong> ${h.address || 'N/A'}<br>
            <strong>Coords:</strong> ${h.latitude}, ${h.longitude}<br>
            <strong>Province:</strong> ${h.provinces_region || 'N/A'}<br>
            ${h.id ? `<a href="/hospitals/${h.id}" class="btn btn-primary btn-sm mt-2" style="color:white;">Read More</a>` : ''}
        `);
    });

    if (hospitalMarkers.getLayers().length > 0)
        map.fitBounds(hospitalMarkers.getBounds(), { padding: [50, 50] });
}

// === Apply Filter ===
async function applyHospitalFilters() {
    const provs = [...document.querySelectorAll('.province-checkbox:checked')].map(e => e.value);
    const levels = [...document.querySelectorAll('input[name="hospitalLevel"]:checked')].map(e => e.value);
    const hospitalSelect = $('#hospital_name_map').val() || '';
    const hospitalName = Array.isArray(hospitalSelect) ? hospitalSelect[0] : hospitalSelect;
    const radius = parseInt(document.getElementById('radiusRangeMap')?.value || 0);

    let filters = {};
    if (hospitalName) filters.name = hospitalName;
    if (provs.length > 0) filters.provinces = provs;
    if (radius > 0 && lastClickedLocation) {
        filters.radius = radius;
        filters.center_lat = lastClickedLocation.lat;
        filters.center_lng = lastClickedLocation.lng;
    }

    const hospitals = await fetchHospitalData(filters);

    const filteredHospitals = hospitals.filter(h => {
        if (levels.length === 0) return true;
        if (!h.facility_level) return false;
        const dbLevels = h.facility_level.split(',').map(c => c.trim().toLowerCase());
        return levels.some(sel => dbLevels.includes(sel.toLowerCase()));
    });

    addHospitalMarkers(filteredHospitals);
    document.getElementById('totalCountDisplay').innerHTML = `<strong>Hospitals:</strong> ${filteredHospitals.length}`;
}

// === Select2 Inisialisasi ===
$(document).ready(function() {
    $('#hospital_name_map').select2({
        width: '100%',
        placeholder: 'Search Hospital',
        allowClear: true
    });

    $('#hospital_name_map').on('change', function() {
        applyHospitalFilters();
    });
});

// === Filter Panel ===
const FilterPanel = L.Control.extend({
    options: { position: 'topright' },
    onAdd: function () {
        const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
        Object.assign(div.style, {
           background: 'white',
            borderRadius: '6px',
            boxShadow: '0 2px 6px rgba(0,0,0,0.2)',
            minWidth: '300px',
            maxWidth: '300px',
            maxHeight: '70vh',
            overflowY: 'auto',
            fontSize: '11px',
            padding: '0'
        });

        div.innerHTML = `
            <button style="background:#007bff;color:white;border:none;width:100%;padding:8px;">Filter & Radius</button>
            <div id="filterPanel" style="padding:10px;">
                <strong>Radius: <span id="radiusValueMap">0</span> km</strong>
                <input type="range" id="radiusRangeMap" min="0" max="500" value="0" style="width:100%;margin-bottom:6px;">
                <div style="display:flex;gap:5px;">
                    <button id="applyRadiusMap" class="btn btn-sm btn-primary flex-fill">Apply</button>
                    <button id="resetRadiusMap" class="btn btn-sm btn-danger flex-fill">Reset</button>
                </div>
                <hr>
                <label>Hospital Name:</label>
                <select id="hospital_name_map" class="form-select form-select-sm mb-2 select-search-hospital">
                    <option value="">Select Hospital</option>
                    @foreach($hospitalNames as $n)
                        <option value="{{ $n }}">{{ $n }}</option>
                    @endforeach
                </select>
                <label>Facility Level:</label>
               ${[
                    { alias: 'Level 1', value: '1 - Village Health Post (VHP)' },
                    { alias: 'Level 2', value: '2 - Community Health Post (CHP)' },
                    { alias: 'Level 3', value: '3 - Health Center / Urban Clinic (HC-UC)' },
                    { alias: 'Level 4', value: '4 - District Hospital - Rural Health Services (DH)' },
                    { alias: 'Level 5', value: '5 - Provincial Hospital, Health Services and Public Health Programs (PHA)' },
                    { alias: 'Level 6', value: '6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)' }
                ].map(c => `
                    <label style="display:block;font-size:12px;">
                        <input type="checkbox" name="hospitalLevel" value="${c.value}">
                        ${c.alias}
                    </label>
                `).join('')}
                <hr>
                <strong>Province</strong>
                <div style="max-height:120px;overflow-y:auto;border:1px solid #ccc;padding:5px;border-radius:5px;margin-top:6px;">
                    @foreach ($provinces as $p)
                        <div class="form-check">
                            <input class="form-check-input province-checkbox" type="checkbox" value="{{ $p->id }}">
                            <label class="form-check-label">{{ $p->provinces_region }}</label>
                        </div>
                    @endforeach
                </div>
                <hr>
                <button id="resetMapFilter" class="btn btn-sm btn-secondary w-100">Reset All</button>
                <div id="totalCountDisplay" style="margin-top:8px;text-align:center;font-size:13px;"></div>
            </div>`;
        L.DomEvent.disableClickPropagation(div);
        return div;
    }
});
map.addControl(new FilterPanel());

// === Events ===
document.addEventListener('input', e => {
    if (e.target.id === 'radiusRangeMap') {
        const r = parseInt(e.target.value || 0);
        document.getElementById('radiusValueMap').textContent = r;
        updateRadiusCircleAndPin(r);
    }
});

document.addEventListener('click', async e => {
    if (e.target.id === 'applyRadiusMap') {
        const radius = parseInt(document.getElementById('radiusRangeMap').value || 0);
        if (radius > 0 && !lastClickedLocation) {
            alert('Klik lokasi di peta untuk menentukan titik radius.');
            return;
        }
        await applyHospitalFilters();
    }

    if (e.target.id === 'resetRadiusMap') {
        document.getElementById('radiusRangeMap').value = 0;
        document.getElementById('radiusValueMap').textContent = '0';
        if (radiusCircle) map.removeLayer(radiusCircle);
        if (radiusPinMarker) map.removeLayer(radiusPinMarker);
        lastClickedLocation = null;
        await applyHospitalFilters();
    }

    if (e.target.id === 'resetMapFilter') {
        document.querySelectorAll('#filterPanel input[type="checkbox"]').forEach(cb => cb.checked = false);
        document.getElementById('hospital_name_map').value = '';
        document.getElementById('radiusRangeMap').value = 0;
        document.getElementById('radiusValueMap').textContent = '0';
        if (radiusCircle) map.removeLayer(radiusCircle);
        if (radiusPinMarker) map.removeLayer(radiusPinMarker);
        lastClickedLocation = null;
        drawnItems.clearLayers();
        drawnPolygonGeoJSON = null;
        await applyHospitalFilters();
    }
});

document.addEventListener('change', e => {
    if (e.target.classList.contains('province-checkbox') || e.target.name === 'hospitalLevel') {
        applyHospitalFilters();
    }
});

// === Inisialisasi Awal ===
applyHospitalFilters();
</script>

@endpush
