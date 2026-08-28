@extends('layouts.master')

@section('title','Detail Clinic')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')

<style>
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

    .clinical-service-table{

    }

    .clinical-service-table td{
        padding: 6px 0;
        border-bottom: 1px solid #dee2e6;
        border-top:none;
        line-height: 18px;
    }

    .card-header{
        padding: 0.25rem 1.25rem;
        color: #3c66b5;
        font-weight: bold;
    }

    .mb-4{
        margin-bottom: 0.5rem !important;
    }

    .clinical-service-table td{
        padding: 6px;
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

    /* Medical Facility Classification modals */
    .medical-info-dialog { width: 95vw; max-width: 1180px !important; }
    .medical-info-modal {
      max-height: 88vh;
      border: none;
      border-radius: 10px;
      overflow: hidden;
      color: #343a40;
      font-family: Arial, Helvetica, sans-serif;
    }
    .medical-info-modal .modal-header {
      min-height: 44px;
      padding: 7px 12px;
      background: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      flex: 0 0 auto;
    }
    .medical-info-modal .modal-title {
      margin-left: 7px;
      color: #202124;
      font-size: 18px;
      font-weight: 400;
      line-height: 24px;
    }
    .medical-info-tabs {
      margin: 0 !important;
      padding: 9px 6px 0 !important;
      background: #f8f9fa;
      border-bottom: 1px solid #dee2e6;
      flex: 0 0 auto;
      flex-wrap: nowrap;
      gap: 2px;
      overflow-x: auto;
    }
    .medical-info-tabs .nav-link {
      min-width: 84px;
      padding: 8px 14px;
      border: 1px solid transparent;
      border-bottom: none;
      border-radius: 6px 6px 0 0;
      background: #eceeef;
      color: #55606e;
      font-size: 12px;
      font-weight: 600;
      white-space: nowrap;
    }
    .medical-info-tabs .nav-link:hover { background: #eef2f7; color: #395272; }
    .medical-info-tabs .nav-link.active {
      background: #fff;
      color: #395272;
      border-color: #dee2e6 #dee2e6 #fff;
    }
    .medical-info-body {
      padding: 0 !important;
      overflow: hidden;
      flex: 1 1 auto;
      min-height: 0;
    }
    .medical-info-content {
      min-height: 260px;
      max-height: calc(88vh - 120px);
      padding: 18px 24px 24px;
      overflow-y: auto;
      font-size: 14px;
      line-height: 19px;
    }
    .medical-info-content .tab-pane > h6:first-child { display: none; }
    .medical-info-content p,
    .medical-info-content li { font-size: 14px; line-height: 19px; }
    .medical-info-content ul { padding-left: 20px; margin-bottom: 12px; }
    .medical-info-content li { margin-bottom: 5px; }
    .medical-info-content .level66-additional-info { padding: 8px 0 0; }

    @media (max-width: 767.98px) {
      .medical-info-dialog { width: calc(100vw - 16px); margin: 8px auto; }
      .medical-info-modal { max-height: calc(100vh - 16px); }
      .medical-info-modal .modal-title { font-size: 15px; line-height: 20px; }
      .medical-info-content {
        max-height: calc(100vh - 126px);
        min-height: 200px;
        padding: 14px 16px 18px;
      }
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
            <!-- Button 2 -->
            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-medical-facility-white.png') }}" style="width: 18px; height: 24px;">
                <small>Clinical</small>
            </a>

            <!-- Button 4 -->
            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>
            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-air-charter.png') }}" style="width: 48px; height: 24px;">
                <small>Air Charter</small>
            </a>

            <a href="{{ url('police') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('police') ? 'active' : '' }}">
            <i class="bi bi-person-badge" style="width: 24px; height: 24px;"></i>
                <small>Police</small>
            </a>

            <!-- Button 7 -->
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
    <div class="col-sm-4">
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
                  </div>
        </div>
    </div>
</div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-menu-medical-facility.png') }}" style="width: 24px; height: 24px;"> Clinical Services</div>
              <div class="card-body overflow-auto">
                <div class="row">
                <div class="col-sm-6">
                    <table class="table table-hover clinical-service-table">
                        <tr>
                            <td>Inpatient</td>
                            <td>{{ $hospital->inpatient_services }}</td>
                        </tr>
                        <tr>
                            <td>Outpatient</td>
                            <td>{{ $hospital->outpatient_services }}</td>
                        </tr>
                        <tr>
                            <td>24 hr ER</td>
                            <td>{{ $hospital->hour_emergency_services }}</td>
                        </tr>
                        <tr>
                            <td>Ambulance</td>
                            <td>{{ $hospital->ambulance }}</td>
                        </tr>
                        <tr>
                            <td>Helipad</td>
                            <td>{{ $hospital->helipad }}</td>
                        </tr>
                        <tr>
                            <td>Note</td>
                            <td>{{ $hospital->comments }}</td>
                        </tr>
                        <tr>
                            <td>ICU</td>
                            <td>{{ $hospital->icu }}</td>
                        </tr>
                        <tr>
                            <td>Medical</td>
                            <td>{{ $hospital->medical }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6">
                    <table class="table table-hover clinical-service-table">
                        <tr>
                            <td>Pediatric</td>
                            <td>{{ $hospital->pediatric }}</td>
                        </tr>
                        <tr>
                            <td>Dental</td>
                            <td>{{ $hospital->dental }}</td>
                        </tr>
                        <tr>
                            <td>Optical</td>
                            <td>{{ $hospital->optical }}</td>
                        </tr>
                        <tr>
                            <td>Integrated Outreach Clinic (IOC)</td>
                            <td>{{ $hospital->ioc }}</td>
                        </tr>
                        <tr>
                            <td>Laboratory</td>
                            <td>{{ $hospital->laboratory }}</td>
                        </tr>
                        <tr>
                            <td>Pharmacy</td>
                            <td>{{ $hospital->pharmacy }}</td>
                        </tr>
                        <tr>
                            <td>Medical Imaging</td>
                            <td>{{ $hospital->medical_imaging }}</td>
                        </tr>
                        <tr>
                            <td>Medical Student Training</td>
                            <td>{{ $hospital->medical_student_training }}</td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="card">
                  <div class="card-header fw-bold"><img src="{{ asset('images/icon-medical-personel.png') }}" style="width: 32px; height: 24px;"> Medical Personnel</div>
             <div class="card-body overflow-auto">
                 <div class="row">
                <div class="col-sm-6">
                <table class="table table-hover clinical-service-table">
                    <tr>
                        <td>Doctors</td>
                        <td>{{ $hospital->doctors }}</td>
                    </tr>
                    <tr>
                        <td>Nurses</td>
                        <td>{{ $hospital->nurses }}</td>
                    </tr>
                    <tr>
                        <td>Dental Therapist</td>
                        <td>{{ $hospital->dental_therapist }}</td>
                    </tr>
                    <tr>
                        <td>Laboratory Assistants</td>
                        <td>{{ $hospital->laboratory_assistants }}</td>
                    </tr>
                    <tr>
                        <td>Community Health Workers/Orderlies</td>
                        <td>{{ $hospital->community_health }}</td>
                    </tr>
                </table>
                </div>
                <div class="col-sm-6">
                <table class="table table-hover clinical-service-table">
                    <tr>
                        <td>Health Inspectors</td>
                        <td>{{ $hospital->health_inspectors }}</td>
                    </tr>
                    <tr>
                        <td>Malaria Control Officers</td>
                        <td>{{ $hospital->malaria_control_officers }}</td>
                    </tr>
                    <tr>
                        <td>Health Extension Officers</td>
                        <td>{{ $hospital->health_extention_officers }}</td>
                    </tr>
                    <tr>
                        <td>Casuals</td>
                        <td>{{ $hospital->casuals }}</td>
                    </tr>
                </table>
                </div>
                </div>
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

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="level66ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable level66-modal-dialog">
    <div class="modal-content level66-modal">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="level66ModalLabel">Level 6 – National Referral Specialist Tertiary and Teaching Hospital - Health Services (NHA)</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <ul class="nav nav-tabs mb-3" id="level66Tabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="level66-overview-tab" data-bs-toggle="tab" data-bs-target="#level66-overview" type="button" role="tab" aria-controls="level66-overview" aria-selected="true">Overview</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="level66-role-tab" data-bs-toggle="tab" data-bs-target="#level66-role" type="button" role="tab" aria-controls="level66-role" aria-selected="false">Role</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="level66-clinical-tab" data-bs-toggle="tab" data-bs-target="#level66-clinical" type="button" role="tab" aria-controls="level66-clinical" aria-selected="false">Clinical Service</button>
                </li>
            </ul>

            <div class="tab-content" id="level66TabsContent">
              <div class="tab-pane fade show active" id="level66-overview" role="tabpanel" aria-labelledby="level66-overview-tab" tabindex="0">
            <h6 class="fw-bold">
                <b>Overview</b>
            </h6>
            <p class="text-justify">
               Level 6 facility is the highest tier of healthcare service in Papua New Guinea, and is the national referral tertiary hospital under the Papua New Guinea National Department of Health (MDOH), providing comprehensive advanced medical, surgical, diagnostic, and subspecialty services supported by highly specialized workforce and national-level infrastructure. Level 6 hospitals are the ultimate referral destination for all lower-level facilities (Levels 1–5), managing the most complex cases while functions as the central hub for clinical governance, specialist training and education, research, and implementation of national health policies, as well as playing a leading role in disaster response coordination, public health surveillance, and overall health system development (e.g. Port Moresby General Hospital).
            </p>
              </div>

              <div class="tab-pane fade" id="level66-role" role="tabpanel" aria-labelledby="level66-role-tab" tabindex="0">
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
              </div>

              <div class="tab-pane fade" id="level66-clinical" role="tabpanel" aria-labelledby="level66-clinical-tab" tabindex="0">
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
              </div>
            </div>

            <div class="level66-additional-info">
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
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const medicalModals = [
        { id: 'level11Modal', prefix: 'medical-level-1' },
        { id: 'level22Modal', prefix: 'medical-level-2' },
        { id: 'level33Modal', prefix: 'medical-level-3' },
        { id: 'level44Modal', prefix: 'medical-level-4' },
        { id: 'level55Modal', prefix: 'medical-level-5' },
        { id: 'level66Modal', prefix: 'medical-level-6' }
    ];

    medicalModals.forEach(function (facility) {
        const modal = document.getElementById(facility.id);
        if (!modal) return;

        const dialog = modal.querySelector('.modal-dialog');
        const content = modal.querySelector('.modal-content');
        const body = modal.querySelector('.modal-body');
        if (!dialog || !content || !body) return;

        dialog.classList.add('medical-info-dialog');
        dialog.classList.remove('level66-modal-dialog');
        dialog.style.maxWidth = '';
        content.classList.add('medical-info-modal');
        content.classList.remove('level66-modal');

        /* Level 6 already contains tabs; only normalize its presentation. */
        const existingTabs = body.querySelector(':scope > .nav-tabs');
        const existingTabContent = body.querySelector(':scope > .tab-content');
        if (existingTabs && existingTabContent) {
            existingTabs.classList.add('medical-info-tabs');
            existingTabContent.classList.add('medical-info-content');
            body.before(existingTabs);
            const additionalInfo = body.querySelector(':scope > .level66-additional-info');
            if (additionalInfo) {
                existingTabContent.querySelector('#level66-clinical')?.appendChild(additionalInfo);
            }
            body.classList.add('medical-info-body');
            return;
        }

        const sections = {
            overview: document.createDocumentFragment(),
            role: document.createDocumentFragment(),
            clinical: document.createDocumentFragment()
        };
        let currentSection = 'overview';

        Array.from(body.childNodes).forEach(function (node) {
            const heading = (node.textContent || '').trim().replace(/\s+/g, ' ');
            if (/^Role$/i.test(heading)) currentSection = 'role';
            if (/^Clinical Services?$/i.test(heading)) currentSection = 'clinical';
            sections[currentSection].appendChild(node);
        });

        const tabs = [
            { key: 'overview', label: 'Overview' },
            { key: 'role', label: 'Role' },
            { key: 'clinical', label: 'Clinical Service' }
        ];
        const nav = document.createElement('ul');
        nav.className = 'nav nav-tabs medical-info-tabs';
        nav.id = facility.prefix + '-tabs';
        nav.setAttribute('role', 'tablist');

        const tabContent = document.createElement('div');
        tabContent.className = 'tab-content medical-info-content';

        tabs.forEach(function (tab, index) {
            const paneId = facility.prefix + '-' + tab.key;
            const buttonId = paneId + '-tab';
            const item = document.createElement('li');
            item.className = 'nav-item';
            item.setAttribute('role', 'presentation');
            item.innerHTML = `<button class="nav-link${index === 0 ? ' active' : ''}" id="${buttonId}" data-bs-toggle="tab" data-bs-target="#${paneId}" type="button" role="tab" aria-controls="${paneId}" aria-selected="${index === 0}">${tab.label}</button>`;
            nav.appendChild(item);

            const pane = document.createElement('div');
            pane.className = 'tab-pane fade' + (index === 0 ? ' show active' : '');
            pane.id = paneId;
            pane.setAttribute('role', 'tabpanel');
            pane.setAttribute('aria-labelledby', buttonId);
            pane.setAttribute('tabindex', '0');
            pane.appendChild(sections[tab.key]);
            tabContent.appendChild(pane);
        });

        body.before(nav);
        body.appendChild(tabContent);
        body.classList.add('medical-info-body');
    });
});
</script>

@endsection

@push('service')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
