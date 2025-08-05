@extends('layouts.master')

@section('title','Detail Clinic')

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
</style>

@endpush

@section('conten')

<div class="card">

     <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2 align-items-center">
            <h2 class="fw-bold">{{ $hospital->name }} - Papua New Guinea</h2>
        </div>

        <div class="d-flex gap-2 ms-auto">

           <button onclick="history.back()" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
               <i class="bi bi-arrow-left fs-3"></i>
                <small>Back</small>
            </button>
            <!-- Button 2 -->
            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-hospital fs-3"></i>
                <small>Clinical Services</small>
            </a>

            <!-- Button 4 -->
            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>
            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Air Charter</small>
            </a>

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <i class="bi bi-bank fs-3"></i>
                <small>Embassies</small>
            </a>
        </div>
    </div>

     <div class="card mb-4">
        <div class="card-body">
            <small><i>Last Updated</i></small>
             <small><i>{{ $hospital->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="card h-400">
                <div class="card-header fw-bold"><i class="fas fa-stethoscope"></i>Clinical Services</div>
              <div class="card-body overflow-auto" style="max-height: 400px;">
                <table class="table table-hover">
                    <tr>
                        <td>Inpatient Services</td>
                        <td>{{ $hospital->inpatient_services }}</td>
                    </tr>
                    <tr>
                        <td>Outpatient Services</td>
                        <td>{{ $hospital->outpatient_services }}</td>
                    </tr>
                    <tr>
                        <td>24 hr ER Service</td>
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
                        <td>Intensive Care Unit (ICU)</td>
                        <td>{{ $hospital->icu }}</td>
                    </tr>
                    <tr>
                        <td>Medical</td>
                        <td>{{ $hospital->medical }}</td>
                    </tr>
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
                        <td>Integraed Outreach Clinic (IOC)</td>
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

        <div class="col-sm-6">
            <div class="card h-400">
                  <div class="card-header fw-bold"><i class="fas fa-user-nurse"></i>Medical Personnel</div>
             <div class="card-body overflow-auto" style="max-height: 400px;">
                <table class="table table-hover">
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
                    <tr>
                        <td>Others</td>
                        <td>{{ $hospital->others }}</td>
                    </tr>
                </table>
            </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')

@endpush
