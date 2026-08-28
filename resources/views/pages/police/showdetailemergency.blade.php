@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Airports')

@push('styles')

<style>
    #map {
        height: 600px;
    }

    table {
        border: 1px solid black;
        border-collapse: collapse;
    }
    td {
        border: 1px solid black;
        padding: 4px;
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
    .class-medical-classification {border: none; text-align: left; text-transform: uppercase; white-space: nowrap;}
    .class-airport-category {border: none; text-transform: uppercase; white-space: nowrap;}
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

    .emergency-legend-toolbar { display:flex; align-items:flex-start; justify-content:space-between; gap:24px; width:100%; padding:10px 14px; overflow-x:auto; }
    .emergency-legend-section { flex:0 0 auto; }
    .legend-grid { display:grid; align-items:start; width:max-content; }
    .legend-grid-item { display:flex; align-items:center; justify-content:flex-start; gap:6px; width:auto; min-height:32px; text-align:left; white-space:nowrap; }
    .legend-grid-item img { flex-shrink:0; object-fit:contain; }
    .airfield-legend-grid { grid-template-columns:repeat(3,max-content); column-gap:12px; }
    .medical-legend-groups { display:flex; align-items:flex-start; }
    .medical-legend-group { flex:1 0 auto; text-align:left; }
    .medical-legend-items { display:flex; align-items:flex-start; gap:10px; }
    .medical-legend-items .legend-grid-item { padding-left:0 !important; }
    .police-legend-grid {
      display: grid !important;
      grid-template-columns: max-content max-content !important;
      grid-template-rows: auto auto;
      grid-auto-flow: row !important;
      column-gap: 20px;
      row-gap: 0;
      width: max-content;
    }

    .police-legend-grid .legend-grid-item:nth-child(1) { grid-column: 1; grid-row: 1; }
    .police-legend-grid .legend-grid-item:nth-child(2) { grid-column: 2; grid-row: 1; }
    .police-legend-grid .legend-grid-item:nth-child(3) { grid-column: 1; grid-row: 2; }
    .police-legend-grid .legend-grid-item:nth-child(4) { grid-column: 2; grid-row: 2; }

    .legend-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0;
        width: 100%;
        align-items: start;
    }

    .legend-grid-item {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        gap: 6px;
        width: 100%;
        text-align: left;
        white-space: nowrap;
    }

    .legend-grid-item img {
        flex-shrink: 0;
    }

    .legend-grid-item small {
        text-align: left;
    }

    /* ====== DIRECTIONS PANEL - Modern Styling ====== */
    #directionsPanel {
        font-family: 'Segoe UI', Roboto, -apple-system, sans-serif !important;
        scrollbar-width: thin;
        scrollbar-color: #c1c1c1 transparent;
    }
    #directionsPanel::-webkit-scrollbar { width: 5px; }
    #directionsPanel::-webkit-scrollbar-thumb {
        background: #c1c1c1; border-radius: 10px;
    }
    #directionsPanel .dp-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 12px;
        background: linear-gradient(135deg, #1a73e8, #4285f4);
        border-radius: 8px 8px 0 0;
        margin: 0;
        color: #fff;
    }
    #directionsPanel .dp-header-title {
        font-size: 14px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    #directionsPanel .dp-header-title i { color: #fff !important; font-size: 16px; }
    #directionsPanel .dp-close-btn {
        background: rgba(255,255,255,0.2);
        border: none;
        color: #fff;
        width: 28px; height: 28px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        transition: background 0.2s;
    }
    #directionsPanel .dp-close-btn:hover { background: rgba(255,255,255,0.35); }
    #directionsPanel .dp-close-btn i { color: #fff !important; }

    /* Google-generated table overrides */
    #directionsPanel table { border: none !important; width: 100%; }
    #directionsPanel td {
        border: none !important;
        padding: 6px 4px !important;
        font-size: 13px;
        vertical-align: top;
    }
    #directionsPanel .adp-directions { margin: 0 !important; }

    /* Route summary (origin → destination bar) */
    #directionsPanel .adp-placemark {
        background: #f0f4ff;
        border-radius: 8px;
        margin-bottom: 8px !important;
        overflow: hidden;
    }
    #directionsPanel .adp-placemark td {
        padding: 10px 12px !important;
        font-weight: 600;
        color: #1a3c6e;
        font-size: 13px;
    }
    #directionsPanel .adp-placemark img {
        filter: hue-rotate(200deg) saturate(1.5);
    }

    /* Summary bar (distance & time) */
    #directionsPanel .adp-summary {
        background: linear-gradient(135deg, #e8f0fe, #d2e3fc);
        border-radius: 8px;
        padding: 10px 14px !important;
        margin: 8px 0 !important;
        font-size: 13px;
        color: #1a3c6e;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Step list */
    #directionsPanel .adp-listsel,
    #directionsPanel .adp-list {
        border: none !important;
    }
    #directionsPanel .adp-listinfo {
        border: none !important;
        background: transparent !important;
    }

    /* Individual step rows */
    #directionsPanel .adp-step {
        border-bottom: 1px solid #eef1f5 !important;
        border-left: none !important;
        border-right: none !important;
        border-top: none !important;
        transition: background 0.15s;
        border-radius: 6px;
        margin-bottom: 2px;
    }
    #directionsPanel .adp-step:hover {
        background: #f5f8ff !important;
    }
    #directionsPanel .adp-step:last-child {
        border-bottom: none !important;
    }

    /* Step icon cell */
    #directionsPanel .adp-step .adp-stepicon {
        padding: 8px 4px 8px 8px !important;
    }
    #directionsPanel .adp-step .adp-stepicon .adp-maneuver {
        width: 20px;
        height: 20px;
    }

    /* Step text */
    #directionsPanel .adp-step .adp-substep {
        padding: 8px 12px 8px 4px !important;
        color: #333;
        line-height: 1.5;
        font-size: 12.5px;
    }
    #directionsPanel .adp-step .adp-substep b {
        color: #1a73e8;
        font-weight: 600;
    }
    /* Step distance */
    #directionsPanel .adp-step td:last-child {
        color: #5f6368;
        font-size: 12px;
        white-space: nowrap;
        padding-right: 10px !important;
    }

    /* Warning / legal */
    #directionsPanel .adp-warnbox,
    #directionsPanel .adp-legal {
        font-size: 11px;
        color: #888;
        padding: 6px 12px !important;
        border: none !important;
    }
    #directionsPanel .adp-legal a { color: #1a73e8; }

    /* Highlighted / selected step */
    #directionsPanel .adp-listsel {
        background: #e8f0fe !important;
        border-radius: 6px;
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
            <h2 class="fw-bold mb-0">{{ $police->name_police }}</h2>
            <span class="fw-bold"><b>Police Classification (Global):</b> {{ $police->level }} | <b>Police Classification (Country):</b> {{ $police->category }}</span>
        </div>

        <div class="d-flex gap-2 ms-auto">

              <!-- Button 2 -->
            <a href="{{ url('police') }}/{{$police->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('police/'.$police->id.'/detail') ? 'active' : '' }}">
                <img src="{{ asset('images/icon-menu-general-info.png') }}" style="width: 18px; height: 24px;">
                <small>General</small>
            </a>

            <!-- Button 5 -->
             <a href="{{ url('police') }}/{{$police->id}}/emergency" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('police/'.$police->id.'/emergency') ? 'active' : '' }}">
                <img src="{{ asset('images/icon-emergency-support-white.png') }}" style="width: 24px; height: 24px;">
                <small>Emergency</small>
            </a>

             <!-- Button 5 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospital') ? 'active' : '' }}">
                 <img src="{{ asset('images/icon-medical.png') }}" style="width: 24px; height: 24px;">
                <small>Medical</small>
            </a>

            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Aviation</small>
            </a>

            <!-- Button 6 -->
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
            <small><i>Last Updated {{ $police->created_at->format('M Y') }}</i></small>

            @role('admin')
            <a href="{{ route('policedata.edit', $police->id) }}"
            style="position:absolute; right:7px;" title="edit">
                <i class="fas fa-edit"></i>
            </a>
            @endrole
        </div>
    </div>

    <div class="row">

        <div class="col-sm-8 d-flex flex-column gap-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-emergency-support.png') }}" style="width: 24px; height: 24px;"> Emergency Support Tools</div>

                  <div class="emergency-legend-toolbar">
                    <!-- Airfield Classification -->
                    <div class="emergency-legend-section">
                        <div class="class-header class-airport-category">Airfield Classification</div>
                        <div class="legend-grid airfield-legend-grid">
                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level6Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png" style="width:18px; height:18px;">
                                  <small>International</small>
                              </button>

                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level5Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png" style="width:18px; height:18px;">
                                  <small>Domestic</small>
                              </button>

                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level4Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png" style="width:18px; height:18px;">
                                  <small>Regional</small>
                              </button>
                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level2Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png" style="width:18px; height:18px;">
                                  <small>Civil-Military</small>
                              </button>

                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level3Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png" style="width:18px; height:18px;">
                                  <small>Military</small>
                              </button>

                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level1Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png" style="width:18px; height:18px;">
                                  <small>Private</small>
                              </button>
                        </div>
                    </div>

                    <!-- Hospital Classification -->
                    <div class="emergency-legend-section">
                      <div class="class-header class-medical-classification">Medical Facility Classification</div>
                      <div class="medical-legend-groups">
                        <!-- Advanced -->
                        <div class="class-column medical-legend-group">
                          <div class="class-header class-advanced">Advanced</div>
                          <div class="medical-legend-items">
                              <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level66Modal">
                                <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                                <small>Level 6</small>
                              </button>
                          </div>
                        </div>

                        <!-- Intermediate -->
                        <div class="class-column medical-legend-group">
                          <div class="class-header class-intermediate">Intermediate</div>
                          <div class="medical-legend-items">
                                <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level55Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                                  <small>Level 5</small>
                                </button>
                                <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level44Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:24px; height:24px;">
                                  <small>Level 4</small>
                                </button>
                          </div>
                        </div>

                        <!-- Basic -->
                        <div class="class-column medical-legend-group">
                          <div class="class-header class-basic">Basic</div>
                          <div class="medical-legend-items">
                                <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level33Modal">
                                  <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                                  <small>Level 3</small>
                                </button>
                                <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level22Modal">
                                    <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:24px; height:24px;">
                                    <small>Level 2</small>
                                </button>
                                <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#level11Modal">
                                    <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:24px; height:24px;">
                                    <small>Level 1</small>
                                </button>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="emergency-legend-section">
                        <div class="class-header class-airport-category">POLICE CLASSIFICATION</div>

                            <div class="legend-grid police-legend-grid">
                                    <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#police4Modal">
                                        <img src="{{ asset('images/Layer1.png') }}" style="width:12px; height:12px;">
                                        <small>National Police HQ</small>
                                    </button>

                                    <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#police3Modal">
                                        <img src="{{ asset('images/Layer2.png') }}" style="width:12px; height:12px;">
                                        <small>Divisional Command</small>
                                    </button>
                                    <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#police2Modal">
                                         <img src="{{ asset('images/Layer3.png') }}" style="width:12px; height:12px;">
                                        <small>Provincial Police Command (PPC)</small>
                                    </button>

                                    <button class="btn p-1 legend-grid-item" data-bs-toggle="modal" data-bs-target="#police1Modal">
                                        <img src="{{ asset('images/Layer4.png') }}" style="width:12px; height:12px;">
                                        <small>District Police Command / Police Station</small>
                                    </button>
                            </div>
                    </div>

                  </div>

                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card">
                <div class="card-header fw-bold"><img src="https://concord-consulting.com/static/img/cmt/icon/radar-icon.png" style="width: 24px; height: 24px;"> Nearest Support Facilities</div>
                <div class="card-body overflow-auto">
                    <?php echo $police->nearest_medical_facility; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/hotlines-icon.png') }}" style="width: 24px; height: 24px;"> Emergency Hotline</div>
                <div class="card-body">
                    <?php echo $hospital->travel_agent; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header fw-bold"><img src="{{ asset('images/icon-medical-support-website.png') }}" style="width: 24px; height: 24px;"> Emergency Medical Support</div>
                <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                        <?php echo $hospital->medical_support_website; ?>
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
        <p class="p-modal text-justify">Also known as private airfields or airstrips are primarily used for general and private aviation are owned by private individuals, groups, corporations, or organizations operated for their exclusive use that may include limited access for authorized personnel by the owner or manager. Owners are responsible to ensure safe operation, maintenance, repair, and control of who can use the facilities. Typically, they are not open to the public or provide scheduled commercial airline services and cater to private pilots, business aviation, and sometimes small charter operations. Services may be provided if authorized by the appropriate regulatory authority.</p>

        <p class="p-modal text-justify">A large majority of private airports are grass or dirt strip fields without services or facilities, they may feature amenities such as hangars, fueling facilities, maintenance services, and ground transportation options tailored to the needs of their owners or users. Private airports are not subject to the same level of regulatory oversight as public airports, but must still comply with applicable aviation regulations, safety standards, and environmental requirements. In the event of an emergency, landing at a private airport is authorized without any prior approval and should be done if landing anywhere else compromises the safety of the aircraft, crew, passengers, or cargo.</p>
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
        <p class="p-modal text-justify">Also called "joint-use airport," are used by both civilian and military aircraft, where a formal agreement exists between the military and a local government agency allowing shared access to infrastructure and facilities, typically with separate passenger terminals and designated operating areas, airspace allocation, and aircraft scheduling. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
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
        <p class="p-modal text-justify">Facilities where military aircraft operate, also known as a military airport, airbase, or air station. Features include aircraft maintenance, air traffic control, communications, emergency response, fuel and weapon storage, defensive systems, aircraft shelters, and personnel facilities.</p>
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
        <p class="p-modal text-justify">A small or remote regional domestic airfield usually located in a geographically isolated area, far from major population centers, often with difficult terrain or vast distances from other airports with limited passenger traffic. May have shorter runways, basic facilities, and limited amenities, and basic infrastructure, serving primarily local communities providing access to essential services like medical transport or regional travel, rather than large-scale commercial flights.</p>
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
        <p class="p-modal text-justify">Exclusively manages flights that originate and end within the same country, does not have international customs or border control facilities. Airport often has smaller and shorter runways, suitable for smaller regional aircraft used on domestic routes, and cannot support larger haul aircraft having less developed support services. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage.</p>
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
        <p class="p-modal text-justify">Meet standards set by the International Air Transport Association (IATA) and the International Civil Aviation Organization (ICAO), facilitate transnational travel managing flights between countries, have customs and border control facilities to manage passengers and cargo, and may have dedicated terminals for domestic and international flights. International airports have longer runways to accommodate larger, heavier aircraft, are often a main hub for air traffic, and can serve as a base for larger airlines. Features can include aircraft maintenance, air traffic control, communications, emergency response, and fuel storage</p>
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

<div class="modal fade" id="police1Modal" tabindex="-1" aria-labelledby="police1ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/Layer4.png') }}" alt="District Police Command" style="width:24px; height:24px; object-fit:contain;">
          <h5 class="modal-title" id="police1ModalLabel">District Police Command / Police Station</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p><strong>Command Level:</strong> Third-tier Territorial Police Command</p>
        <p><strong>Typical Head Rank:</strong> Superintendent of Police (SP) or Inspector of Police (IP)</p>
        <p><strong>Administrative Equivalent:</strong> District level</p>

        <p>Supervises police operations within a district by directing police stations and subordinate units, coordinating patrol activities, maintaining public order, supporting criminal investigations, and ensuring effective delivery of policing services within their jurisdiction.</p>

        <p class="mb-2"><strong>Responsibilities:</strong></p>
        <ul>
          <li>Command district-level police operations.</li>
          <li>Supervise Police Station Commanders within the district.</li>
          <li>Coordinate patrol, crime prevention, and law enforcement activities.</li>
          <li>Direct responses to local emergencies and major incidents.</li>
          <li>Allocate operational personnel and resources among police stations.</li>
          <li>Monitor crime trends and operational performance within the district.</li>
          <li>Coordinate policing with district administrations and community leaders.</li>
          <li>Ensure implementation of provincial operational directives.</li>
          <li>Prepare operational reports for the Provincial Police Commander (PPCs).</li>
          <li>Support community policing and conflict-resolution initiatives.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police2Modal" tabindex="-1" aria-labelledby="police2ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/Layer3.png') }}" alt="Provincial Police Command" style="width:24px; height:24px; object-fit:contain;">
          <h5 class="modal-title" id="police2ModalLabel">Provincial Police Command (PPC)</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p><strong>Command Level:</strong> Second-tier Territorial Police Command</p>
        <p><strong>Typical Head Rank:</strong> Chief Superintendent of Police (CSP) or Superintendent of Police (SP)</p>
        <p><strong>Administrative Equivalent:</strong> Provincial (or Metropolitan Command in the National Capital District and Lae) level</p>

        <p>Commands all policing activities within a province or metropolitan area by directing district police commands, managing crime prevention and law enforcement operations, coordinating emergency responses, and implementing national policing policies at the provincial level.</p>

        <p class="mb-2"><strong>Responsibilities:</strong></p>
        <ul>
          <li>Command all policing operations within a province.</li>
          <li>Supervise District Police Commanders and Station Commanders.</li>
          <li>Coordinate crime prevention, patrol, and public order operations.</li>
          <li>Direct provincial criminal investigations and emergency responses.</li>
          <li>Manage police personnel, logistics, and operational resources within the province.</li>
          <li>Coordinate policing activities with provincial administrations and local authorities.</li>
          <li>Monitor crime patterns and public safety issues.</li>
          <li>Ensure compliance with national policing standards and operational procedures.</li>
          <li>Prepare operational reports for the Divisional Police Commander.</li>
          <li>Promote community policing and public engagement initiatives.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police3Modal" tabindex="-1" aria-labelledby="police3ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/Layer2.png') }}" alt="Divisional Command" style="width:24px; height:24px; object-fit:contain;">
          <h5 class="modal-title" id="police3ModalLabel">Divisional Command</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p><strong>Command Level:</strong> Top Territorial Police Command</p>
        <p><strong>Typical Head Rank:</strong> Assistant Commissioner of Police (ACP)</p>
        <p><strong>Administrative Equivalent:</strong> Multi-provincial police region (Police Division)</p>

        <p>Exercises operational command over one of the RPNGC's territorial police divisions by supervising provincial and metropolitan police commands, implementing national policing strategies, coordinating regional law enforcement operations, and ensuring the effective delivery of policing services across multiple provinces.</p>

        <p class="mb-2"><strong>Responsibilities:</strong></p>
        <ul>
          <li>Command a Regional (Divisional) Police Command.</li>
          <li>Supervise Provincial Police Commanders (PPCs) within the division.</li>
          <li>Coordinate regional law enforcement operations and public order activities.</li>
          <li>Allocate personnel and operational resources among provincial commands.</li>
          <li>Monitor crime trends and operational performance across the division.</li>
          <li>Coordinate multi-provincial investigations and security operations.</li>
          <li>Support disaster response and emergency management activities.</li>
          <li>Ensure implementation of national policing policies and operational directives.</li>
          <li>Report regional operational performance to the Deputy Commissioner (Regional Operations).</li>
          <li>Strengthen cooperation with provincial governments and regional stakeholders.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="police4Modal" tabindex="-1" aria-labelledby="police4ModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:800px;">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ asset('images/Layer1.png') }}" alt="National Police HQ" style="width:24px; height:24px; object-fit:contain;">
          <h5 class="modal-title" id="police4ModalLabel">National Police HQ</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <p><strong>Command Level:</strong> National Police Commander</p>
        <p><strong>Typical Head Rank:</strong> Commissioner of Police (COP)</p>

        <p><strong>Role:</strong> Highest commander of the RPNGC and chief executive responsible for national police leadership, strategic direction, and institutional governance.</p>

        <p>Exercises overall command, control, and administration of the RPNGC by directing national policing operations, implementing government policing policies, and ensuring the effective delivery of law enforcement services throughout PNG.</p>

        <p class="mb-2"><strong>Responsibilities:</strong></p>
        <ul>
          <li>Exercise overall command and control of the RPNGC.</li>
          <li>Formulate national policing strategies and organizational priorities.</li>
          <li>Advise the Minister for Police and the National Executive Council on policing and internal security matters.</li>
          <li>Direct and supervise Deputy Commissioners and senior executive officers.</li>
          <li>Oversee law enforcement, public order, criminal investigations, and national security-related policing operations.</li>
          <li>Ensure compliance with the Constitution, the Police Act 1998, and other applicable legislation.</li>
          <li>Manage institutional governance, accountability, ethics, and professional standards.</li>
          <li>Represent the RPNGC in intergovernmental, regional, and international policing cooperation.</li>
          <li>Approve organizational restructuring, resource allocation, and strategic development initiatives.</li>
          <li>Promote modernization, professionalization, and capacity-building throughout the Constabulary.</li>
        </ul>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCd-WVlGgZFJwAtPZkbAEca2Np6OI7CBTM&libraries=places,geometry"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const policeData = {!! json_encode([
        'id'        => $police->id,
        'name'      => $police->name_police,
        'latitude'  => $police->latitude,
        'longitude' => $police->longitude,
        'icon'      => $police->icon ?? '',
        'location'  => $police->location ?? '',
        'telephone' => $police->telephone ?? '',
        'website'   => $police->website ?? '',
    ]) !!};

    const nearbyHospitals = @json($nearbyHospitals);
    const nearbyAirports = @json($nearbyAirports);
    const nearbyPolices = @json($nearbyPolices);
    const nearbyEmbassy = @json($nearbyEmbassy);
    let radiusKm = 100; // default radius

    let map, mainMarker, radiusCircle, directionsService, directionsRenderer;
    let nearbyMarkersGroup = [];
    let searchLocation = null;
    let searchMarker = null;

    // === ICON DEFAULT ===
    const DEFAULT_HOSPITAL_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png';
    const DEFAULT_AIRPORT_ICON_URL  = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png';
    const DEFAULT_MAIN_POLICE_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png';
    const DEFAULT_POLICE_ICON_URL = 'https://png.pngtree.com/png-vector/20221211/ourmid/pngtree-minimal-location-map-icon-logo-symbol-vector-design-transparent-background-png-image_6520892.png';
    const DEFAULT_EMBASSY_ICON_URL = '/images/embassy-icon-new.png';

    // === INISIALISASI PETA ===
    function initializeMap() {
        const center = new google.maps.LatLng(policeData.latitude, policeData.longitude);
        map = new google.maps.Map(document.getElementById('map'), {
            center: center,
            zoom: 11,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            mapTypeControl: true,
            fullscreenControl: true,
            streetViewControl: false
        });

        const directionsPanel = document.createElement('div');
        directionsPanel.id = 'directionsPanel';
        directionsPanel.style.width = '370px';
        directionsPanel.style.maxHeight = '450px';
        directionsPanel.style.overflowY = 'auto';
        directionsPanel.style.backgroundColor = 'white';
        directionsPanel.style.display = 'none';
        directionsPanel.style.boxShadow = '0 4px 20px rgba(0,0,0,0.2)';
        directionsPanel.style.borderRadius = '12px';
        directionsPanel.style.margin = '10px';
        directionsPanel.style.padding = '0';
        directionsPanel.style.fontSize = '13px';

        // Header
        const dpHeader = document.createElement('div');
        dpHeader.className = 'dp-header';
        dpHeader.innerHTML = `
            <div class="dp-header-title">
                <i class="fas fa-route"></i> Route Directions
            </div>
            <button class="dp-close-btn" title="Close">
                <i class="fas fa-times"></i>
            </button>
        `;
        directionsPanel.appendChild(dpHeader);

        // Content area (Google renders steps here)
        const dpContent = document.createElement('div');
        dpContent.style.padding = '10px';
        directionsPanel.appendChild(dpContent);

        // Close button handler
        dpHeader.querySelector('.dp-close-btn').addEventListener('click', () => {
            directionsPanel.style.display = 'none';
            directionsRenderer.setDirections({routes: []});
        });

        google.maps.event.addDomListener(directionsPanel, 'click', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'dblclick', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'mousedown', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'touchstart', e => e.stopPropagation());
        google.maps.event.addDomListener(directionsPanel, 'wheel', e => e.stopPropagation());

        map.controls[google.maps.ControlPosition.LEFT_BOTTOM].push(directionsPanel);

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
            panel: dpContent,
            suppressMarkers: true,
            polylineOptions: {
                strokeColor: '#1a73e8',
                strokeOpacity: 0.8,
                strokeWeight: 5
            }
        });
    }

    function addMainPoliceAndCircle() {
        mainMarker = new google.maps.Marker({
            position: new google.maps.LatLng(policeData.latitude, policeData.longitude),
            map: map,
            icon: {
                url: DEFAULT_MAIN_POLICE_ICON_URL,
                scaledSize: new google.maps.Size(25, 41)
            },
            title: policeData.name
        });

        const infoWindow = new google.maps.InfoWindow({
            content: `<b>${policeData.name}</b><br>This is the main police station.`
        });

        mainMarker.addListener('click', () => {
            infoWindow.open(map, mainMarker);
        });

        radiusCircle = new google.maps.Circle({
            strokeColor: '#FF0000',
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: '#FF0000',
            fillOpacity: 0.1,
            map: map,
            center: { lat: parseFloat(policeData.latitude), lng: parseFloat(policeData.longitude) },
            radius: radiusKm * 1000
        });
    }

    function clearNearbyMarkers() {
        for (let i = 0; i < nearbyMarkersGroup.length; i++) {
            nearbyMarkersGroup[i].setMap(null);
        }
        nearbyMarkersGroup = [];
    }

    // === Tambahkan Marker Sekitar ===
    function addNearbyMarkers(data, defaultIconUrl, type, filters = {}) {
        data.forEach(item => {
            const distance = calculateDistance(
                policeData.latitude, policeData.longitude,
                item.latitude, item.longitude
            );
            if (distance > radiusKm) return;

            // Filter hospital
            if (type === 'Hospital' && filters.hospitalLevels?.length > 0) {
                const level = (item.facility_level || '').toLowerCase();
                const allowed = filters.hospitalLevels.map(l => l.toLowerCase());
                if (!allowed.includes(level)) return;
            }

            // Filter airport
            if (type === 'Airport' && filters.airportClassifications?.length > 0) {
                const categories = (item.category || '').split(',').map(c => c.trim().toLowerCase());
                const allowed = filters.airportClassifications.map(c => c.toLowerCase());
                if (!categories.some(cat => allowed.includes(cat))) return;
            }

            // Filter police
            if (type === 'Police' && filters.policeCategories?.length > 0) {
                const categories = (item.category || '').split(',').map(c => c.trim().toLowerCase());
                const allowed = filters.policeCategories.map(c => c.toLowerCase());
                if (!categories.some(cat => allowed.includes(cat))) return;
            }

            const isPolice = type === 'Police';
            const iconSize = isPolice ? new google.maps.Size(12, 12) : new google.maps.Size(24, 24);

            const marker = new google.maps.Marker({
                position: { lat: parseFloat(item.latitude), lng: parseFloat(item.longitude) },
                map: map,
                icon: {
                    url: item.icon || defaultIconUrl,
                    scaledSize: iconSize
                }
            });

            const name = item.name || item.airport_name || item.name_police || item.name_embassiees || 'N/A';
            const level = item.facility_level || item.category || '';

            let url = '#';
            if (type === 'Airport') url = `/airports/${item.id}/detail`;
            else if (type === 'Hospital') url = `/hospitals/${item.id}`;
            else if (type === 'Police') url = `/police/${item.id}/detail`;
            else if (type === 'Embassy') url = `/embassiees/${item.id}/detail`;

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="font-size:13px;">
                        <a href="${url}" target="_blank">${name}</a><br>
                        ${level}<br>
                        <strong>Distance:</strong> ${distance.toFixed(2)} km<br>
                        <button class="btn btn-sm btn-primary mt-2"
                            onclick="getDirection(${item.latitude}, ${item.longitude})">
                            Get Direction
                        </button>
                    </div>
                `
            });

            marker.addListener('click', () => {
                infoWindow.open(map, marker);
            });

            nearbyMarkersGroup.push(marker);
        });
    }

    function calculateDistance(lat1, lon1, lat2, lon2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) ** 2 +
            Math.cos(lat1 * Math.PI / 180) *
            Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLon / 2) ** 2;
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    // === NEARBY HOTELS (shown once a location is searched) ===
    let categoryMarkers   = [];
    let activeCategoryBtn = null;
    let categoryBar       = null;

    function resetCategoryBtn(btn) {
        btn.style.background  = '#fff';
        btn.style.color       = '#222';
        btn.style.borderColor = 'rgba(0,0,0,0.12)';
    }

    function clearCategoryMarkers() {
        categoryMarkers.forEach(m => m.setMap(null));
        categoryMarkers = [];
    }

    function showNearbyCategory(type, label) {
        if (!searchLocation) return;
        clearCategoryMarkers();

        const center  = new google.maps.LatLng(searchLocation.lat, searchLocation.lng);
        const service = new google.maps.places.PlacesService(map);

        const iconColors = { lodging: '#1a73e8' };
        const color = iconColors[type] || '#555';

        function makeSvgIcon(col) {
            const svg = `<svg xmlns='http://www.w3.org/2000/svg' width='32' height='40' viewBox='0 0 32 40'>`
                      + `<path d='M16 0C7.16 0 0 7.16 0 16c0 12 16 24 16 24S32 28 32 16C32 7.16 24.84 0 16 0z' fill='${col}'/>`
                      + `<circle cx='16' cy='16' r='7' fill='#fff'/>`
                      + `</svg>`;
            return 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(svg);
        }

        service.nearbySearch({ location: center, radius: 5000, type }, (results, status) => {
            if (status !== google.maps.places.PlacesServiceStatus.OK) {
                if (status === 'ZERO_RESULTS') {
                    alert(`No ${label.toLowerCase()} found within 5 km.`);
                } else {
                    alert(`Failed to load ${label.toLowerCase()}. Error status: ${status}. Please ensure "Places API" is enabled and billing is active.`);
                    console.error('PlacesService nearbySearch failed with status:', status);
                }
                return;
            }
            if (!results.length) return;

            results.forEach(place => {
                if (!place.geometry?.location) return;

                const marker = new google.maps.Marker({
                    position: place.geometry.location,
                    map,
                    title: place.name,
                    icon: { url: makeSvgIcon(color), scaledSize: new google.maps.Size(32, 40) },
                    animation: google.maps.Animation.DROP
                });

                const dist     = google.maps.geometry.spherical.computeDistanceBetween(center, place.geometry.location);
                const distText = dist >= 1000 ? (dist / 1000).toFixed(1) + ' km' : Math.round(dist) + ' m';
                const rating   = place.rating ? `⭐ ${place.rating.toFixed(1)}` : '';
                const destLat  = place.geometry.location.lat();
                const destLng  = place.geometry.location.lng();

                const infoWindow = new google.maps.InfoWindow({
                    content: `
                        <div style="font-size:13px;min-width:190px;">
                            <h5 style="border-bottom:1px solid #ccc;margin:0 0 6px;font-size:14px;">${place.name}</h5>
                            <div style="color:#666;font-size:12px;margin-bottom:3px;">${label}</div>
                            ${rating  ? `<div style="font-size:12px;">${rating}</div>` : ''}
                            <div style="margin-top:4px;font-size:12px;color:#555;"> ${distText} from search location</div>
                            <button class="btn btn-sm btn-primary mt-2"
                                onclick="getDirection(${destLat}, ${destLng})">
                                Get Direction
                            </button>
                        </div>`
                });

                marker.addListener('click', () => {
                    infoWindow.open(map, marker);
                });

                categoryMarkers.push(marker);
            });
        });
    }

    function setupNearbyCategoryBar() {
        categoryBar = document.createElement('div');
        categoryBar.id = 'nearbyCategBar';
        Object.assign(categoryBar.style, {
            display:       'none',
            background:    'transparent',
            padding:       '8px 10px 0',
            gap:           '8px',
            flexWrap:      'nowrap',
            overflowX:     'auto',
            maxWidth:      '90vw',
            scrollbarWidth:'none'
        });

        const nearbyCategories = [
            { label: 'Hotels', icon: '🏨', type: 'lodging' }
        ];

        nearbyCategories.forEach(cat => {
            const btn = document.createElement('button');
            btn.textContent = cat.icon + ' ' + cat.label;
            Object.assign(btn.style, {
                display:      'inline-flex',
                alignItems:   'center',
                gap:          '4px',
                padding:      '6px 14px',
                borderRadius: '20px',
                border:       '1px solid rgba(0,0,0,0.12)',
                background:   '#fff',
                color:        '#222',
                fontSize:     '13px',
                fontWeight:   '500',
                cursor:       'pointer',
                whiteSpace:   'nowrap',
                boxShadow:    '0 1px 4px rgba(0,0,0,0.15)',
                transition:   'all 0.15s'
            });

            btn.addEventListener('click', () => {
                if (activeCategoryBtn === btn) {
                    clearCategoryMarkers();
                    resetCategoryBtn(btn);
                    activeCategoryBtn = null;
                    return;
                }
                if (activeCategoryBtn) resetCategoryBtn(activeCategoryBtn);
                activeCategoryBtn = btn;
                btn.style.background = '#1a73e8';
                btn.style.color      = '#fff';
                btn.style.borderColor= '#1a73e8';
                showNearbyCategory(cat.type, cat.label);
            });

            categoryBar.appendChild(btn);
        });

        map.controls[google.maps.ControlPosition.TOP_CENTER].push(categoryBar);
    }

    // === ROUTING ===
    window.getDirection = function(lat, lng) {
        const origin = searchLocation
            ? new google.maps.LatLng(searchLocation.lat, searchLocation.lng)
            : new google.maps.LatLng(policeData.latitude, policeData.longitude);

        directionsService.route({
            origin: origin,
            destination: new google.maps.LatLng(lat, lng),
            travelMode: 'DRIVING'
        }, (response, status) => {
            if (status === 'OK') {
                directionsRenderer.setDirections(response);
                const panel = document.getElementById('directionsPanel');
                if(panel) panel.style.display = 'block';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Route Not Found',
                    text: status === 'ZERO_RESULTS'
                        ? 'No driving route could be found between these two locations.'
                        : 'Directions request failed (' + status + ').',
                    confirmButtonColor: '#d33'
                });
            }
        });
    };

    function fitMapToBounds() {
        const bounds = new google.maps.LatLngBounds();
        bounds.extend(new google.maps.LatLng(policeData.latitude, policeData.longitude));
        if (searchLocation) {
            bounds.extend(new google.maps.LatLng(searchLocation.lat, searchLocation.lng));
        }
        nearbyMarkersGroup.forEach(m => bounds.extend(m.getPosition()));

        const circleBounds = radiusCircle.getBounds();
        if(circleBounds) {
            bounds.union(circleBounds);
        }

        map.fitBounds(bounds);
    }

    function updateMarkers(filterType, hospitalLevels, airportClassifications, policeCategories) {
        clearNearbyMarkers();
        if (radiusCircle) radiusCircle.setMap(null);
        addMainPoliceAndCircle();

        const filters = { hospitalLevels, airportClassifications, policeCategories };
        if (filterType === 'hospital') {
            addNearbyMarkers(nearbyHospitals, DEFAULT_HOSPITAL_ICON_URL, 'Hospital', filters);
        } else if (filterType === 'airport') {
            addNearbyMarkers(nearbyAirports, DEFAULT_AIRPORT_ICON_URL, 'Airport', filters);
        } else if (filterType === 'police') {
            addNearbyMarkers(nearbyPolices, DEFAULT_POLICE_ICON_URL, 'Police', filters);
        } else if (filterType === 'embassy') {
            addNearbyMarkers(nearbyEmbassy, DEFAULT_EMBASSY_ICON_URL, 'Embassy', filters);
        } else {
            addNearbyMarkers(nearbyHospitals, DEFAULT_HOSPITAL_ICON_URL, 'Hospital', filters);
            addNearbyMarkers(nearbyAirports, DEFAULT_AIRPORT_ICON_URL, 'Airport', filters);
            addNearbyMarkers(nearbyPolices, DEFAULT_POLICE_ICON_URL, 'Police', filters);
            addNearbyMarkers(nearbyEmbassy, DEFAULT_EMBASSY_ICON_URL, 'Embassy', filters);
        }

        fitMapToBounds();
    }

    // === FILTER CONTROL ===
    function setupFilterControl() {
        const container = document.createElement('div');
        container.className = 'p-2 bg-white rounded';
        container.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
        container.style.width = '220px';
        container.style.maxHeight = '75vh';
        container.style.overflowY = 'auto';
        container.style.marginRight = '10px';
        container.style.marginTop = '10px';
        container.style.cursor = 'default';

        container.innerHTML = `
            <h6><strong>Filter</strong></h6>

            <strong style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;color:#555;">Search Location</strong>
            <div style="position:relative;margin-top:5px;">
                <input type="text" id="gmSearchInput" class="form-control form-control-sm"
                    placeholder="Search Location..." autocomplete="off" style="padding-right:28px;">
                <i class="fas fa-times" id="gmClearBtn"
                    style="position:absolute;right:8px;top:50%;transform:translateY(-50%);color:#70757a;font-size:13px;cursor:pointer;display:none;"></i>
            </div>

            <label><strong>Radius:</strong> <span id="radiusLabel">${radiusKm}</span> km</label>
            <input type="range" id="radiusRange" min="10" max="500" step="10" value="${radiusKm}" class="form-range mb-2" style="display:block;width:100%;">

            <select id="mapFilter" class="form-select form-select-sm mb-2" style="display:block;width:100%;">
                <option value="all">Show All</option>
                <option value="hospital">Hospitals</option>
                <option value="airport">Aviation</option>
                <option value="police">Police</option>
                <option value="embassy">Embassy</option>
            </select>

            <div id="hospitalFilter" style="display:none;">
                <strong>Facility Level:</strong><br>
                ${[
                    { alias: 'Level 6', value: '6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)' },
                    { alias: 'Level 5', value: '5 - Provincial Hospital, Health Services and Public Health Programs (PHA)' },
                    { alias: 'Level 4', value: '4 - District Hospital - Rural Health Services (DH)' },
                    { alias: 'Level 3', value: '3 - Health Center / Urban Clinic (HC-UC)' },
                    { alias: 'Level 2', value: '2 - Community Health Post (CHP)' },
                    { alias: 'Level 1', value: '1 - Village Health Post (VHP)' }
                  ]
                   .map(lvl => `<label style="display:block;font-size:13px;">
                            <input type="checkbox" name="hospitalLevel" value="${lvl}"> ${lvl}
                        </label>`).join('')}
            </div>

            <div id="airportFilter" style="display:none;margin-top:8px;">
                <strong>Category:</strong><br>
                ${['International','Domestic','Military','Regional','Private']
                    .map(cls => `<label style="display:block;font-size:13px;">
                        <input type="checkbox" name="airportClass" value="${cls}"> ${cls}
                    </label>`).join('')}
            </div>

            <div id="policeFilter" style="display:none;margin-top:8px;">
                <strong>Police Category:</strong><br>
                ${[
                    'National Police HQ',
                    'Divisional Command',
                    'Provincial Police Command (PPC)',
                    'District Police Command / Police Station'
                  ].map(cat => `
                    <label style="display:block;font-size:13px;">
                        <input type="checkbox" name="policeCategory" value="${cat}"> ${cat}
                    </label>
                `).join('')}
            </div>

            <button id="resetFilter" class="btn btn-sm btn-secondary mt-3 w-100">Reset Filter</button>
        `;

        // Prevent events from passing to the map
        google.maps.event.addDomListener(container, 'click', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'dblclick', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'mousedown', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'touchstart', e => e.stopPropagation());
        google.maps.event.addDomListener(container, 'wheel', e => e.stopPropagation());

        map.controls[google.maps.ControlPosition.RIGHT_TOP].push(container);

        const radiusSlider = container.querySelector('#radiusRange');
        const radiusLabel = container.querySelector('#radiusLabel');
        radiusSlider.addEventListener('input', () => {
            radiusKm = parseInt(radiusSlider.value);
            radiusLabel.textContent = radiusKm;
            refreshFilters();
        });

        const filterSelect = container.querySelector('#mapFilter');
        const hospitalDiv = container.querySelector('#hospitalFilter');
        const airportDiv = container.querySelector('#airportFilter');
        const policeDiv = container.querySelector('#policeFilter');
        const resetBtn = container.querySelector('#resetFilter');

        function refresh() {
            const selectedType = filterSelect.value;
            const selectedHospitalLevels = Array.from(container.querySelectorAll('input[name="hospitalLevel"]:checked')).map(el => el.value);
            const selectedAirportClasses = Array.from(container.querySelectorAll('input[name="airportClass"]:checked')).map(el => el.value);
            const selectedPoliceCategories = Array.from(container.querySelectorAll('input[name="policeCategory"]:checked')).map(el => el.value);
            updateMarkers(selectedType, selectedHospitalLevels, selectedAirportClasses, selectedPoliceCategories);
        }

        filterSelect.addEventListener('change', () => {
            const val = filterSelect.value;
            hospitalDiv.style.display = val === 'hospital' ? 'block' : 'none';
            airportDiv.style.display = val === 'airport' ? 'block' : 'none';
            policeDiv.style.display = val === 'police' ? 'block' : 'none';
            refresh();
        });

        container.querySelectorAll('input[name="hospitalLevel"]').forEach(chk => chk.addEventListener('change', refresh));
        container.querySelectorAll('input[name="airportClass"]').forEach(chk => chk.addEventListener('change', refresh));
        container.querySelectorAll('input[name="policeCategory"]').forEach(chk => chk.addEventListener('change', refresh));

        resetBtn.addEventListener('click', () => {
            container.querySelectorAll('input[type="checkbox"]').forEach(chk => chk.checked = false);
            filterSelect.value = 'all';
            hospitalDiv.style.display = 'none';
            airportDiv.style.display = 'none';
            policeDiv.style.display = 'none';
            radiusKm = 100;
            radiusSlider.value = radiusKm;
            radiusLabel.textContent = radiusKm;

            const gmInput = container.querySelector('#gmSearchInput');
            if(gmInput) gmInput.value = '';

            if (searchMarker) {
                searchMarker.setMap(null);
                searchMarker = null;
            }
            searchLocation = null;

            if (categoryBar) categoryBar.style.display = 'none';
            clearCategoryMarkers();
            if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

            directionsRenderer.setDirections({routes: []});
            const panel = document.getElementById('directionsPanel');
            if(panel) panel.style.display = 'none';

            refresh();
        });

        return container;
    }

    function refreshFilters() {
        const selectedType = document.querySelector('#mapFilter')?.value || 'all';
        const selectedHospitalLevels = Array.from(document.querySelectorAll('input[name="hospitalLevel"]:checked')).map(el => el.value);
        const selectedAirportClasses = Array.from(document.querySelectorAll('input[name="airportClass"]:checked')).map(el => el.value);
        const selectedPoliceCategories = Array.from(document.querySelectorAll('input[name="policeCategory"]:checked')).map(el => el.value);
        updateMarkers(selectedType, selectedHospitalLevels, selectedAirportClasses, selectedPoliceCategories);
    }

    // === SEARCH LOCATION CONTROL (now part of the filter panel) ===
    function setupSearchControl(filterContainer) {
        const input = filterContainer.querySelector('#gmSearchInput');
        const clearBtn = filterContainer.querySelector('#gmClearBtn');
        if (!input || !clearBtn) return;

        input.addEventListener('keydown', (e) => {
            if(e.key === 'Enter') e.preventDefault();
        });

        const autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo('bounds', map);

        // The input lives inside a custom map control, so Google's ".pac-container"
        // dropdown (appended to <body> with position:absolute) ends up clipped/
        // hidden behind the map's own control panes. Force position:fixed and keep
        // re-applying it, since Google resets the container's inline style on every
        // prediction update (a one-shot fix gets silently overwritten).
        let pacContainer = null;

        function fixPacPosition() {
            if (!pacContainer) return;
            if (pacContainer.parentElement !== document.body) {
                document.body.appendChild(pacContainer);
            }
            const rect = input.getBoundingClientRect();
            pacContainer.style.position = 'fixed';
            pacContainer.style.zIndex = '2147483647';
            pacContainer.style.top = (rect.bottom + 2) + 'px';
            pacContainer.style.left = rect.left + 'px';
            pacContainer.style.width = rect.width + 'px';
            pacContainer.style.visibility = 'visible';
            pacContainer.style.opacity = '1';
            pacContainer.style.pointerEvents = 'auto';
        }

        function claimPacContainer() {
            if (pacContainer) return true;
            pacContainer = document.querySelector('.pac-container');
            if (pacContainer) {
                fixPacPosition();
                new MutationObserver(fixPacPosition).observe(
                    pacContainer, { attributes: true, attributeFilter: ['style'] }
                );
                return true;
            }
            return false;
        }

        const pacObserver = new MutationObserver(() => claimPacContainer());
        pacObserver.observe(document.body, { childList: true, subtree: true });

        // Fallback in case Google created ".pac-container" before the observer
        // above started watching (a MutationObserver only reports *future*
        // mutations, so a container created earlier would otherwise be missed).
        if (!claimPacContainer()) {
            const pollId = setInterval(() => {
                if (claimPacContainer()) clearInterval(pollId);
            }, 200);
            setTimeout(() => clearInterval(pollId), 10000);
        }

        window.addEventListener('scroll', fixPacPosition, true);
        window.addEventListener('resize', fixPacPosition);
        input.addEventListener('focus', fixPacPosition);
        input.addEventListener('input', fixPacPosition);

        input.addEventListener('input', (e) => {
            if (e.target.value.length > 0) {
                clearBtn.style.display = 'block';
            } else {
                clearBtn.style.display = 'none';
            }
        });

        clearBtn.addEventListener('click', () => {
            input.value = '';
            clearBtn.style.display = 'none';
            input.focus();
            if (pacContainer) pacContainer.style.display = 'none';

            if (searchMarker) {
                searchMarker.setMap(null);
                searchMarker = null;
            }
            searchLocation = null;

            if (categoryBar) categoryBar.style.display = 'none';
            clearCategoryMarkers();
            if (activeCategoryBtn) { resetCategoryBtn(activeCategoryBtn); activeCategoryBtn = null; }

            directionsRenderer.setDirections({routes: []});
            const panel = document.getElementById('directionsPanel');
            if(panel) panel.style.display = 'none';
        });

        autocomplete.addListener('place_changed', () => {
            const place = autocomplete.getPlace();
            if (!place.geometry || !place.geometry.location) {
                return;
            }

            if (searchMarker) searchMarker.setMap(null);

            searchMarker = new google.maps.Marker({
                map: map,
                position: place.geometry.location,
                icon: {
                    url: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                    scaledSize: new google.maps.Size(25, 41)
                }
            });

            const lat = place.geometry.location.lat();
            const lon = place.geometry.location.lng();
            searchLocation = { lat: lat, lng: lon };

            if (categoryBar) categoryBar.style.display = 'flex';

            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="font-size:13px;">
                        <b>${place.name}</b><br>
                        <small>Lat: ${lat.toFixed(5)}, Lng: ${lon.toFixed(5)}</small><br>
                        <button class="btn btn-sm btn-primary mt-2"
                            onclick="getDirection(${policeData.latitude}, ${policeData.longitude})">
                            Get Direction to Main Police Station
                        </button>
                    </div>
                `
            });

            infoWindow.open(map, searchMarker);
            searchMarker.addListener('click', () => {
                infoWindow.open(map, searchMarker);
            });

            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(14);
            }
        });
    }

    // === JALANKAN ===
    initializeMap();
    addMainPoliceAndCircle();
    updateMarkers('all', [], [], []);
    const filterContainer = setupFilterControl();
    setupSearchControl(filterContainer);
    setupNearbyCategoryBar();
});
</script>

@endpush
