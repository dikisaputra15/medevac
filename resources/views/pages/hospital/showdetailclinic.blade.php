@extends('layouts.master')

@section('title','Detail Clinic')

@push('styles')

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2">

            <!-- Button 2 -->
            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-hospital fs-3"></i>
                <small>Clinical Services</small>
            </a>

            <!-- Button 4 -->
            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>

        </div>

        <div class="d-flex gap-2 ms-auto">
            <!-- Button 5 -->
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
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

     <div class="card mb-4">
        <div class="card-body">
            <h4 class="card-title fw-bold">{{ $hospital->name }} - Papua New Guinea <small><i>Last Updated</i></small></h4>
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
                        <td>{{ $hospital->laboratory_assitent }}</td>
                    </tr>
                    <tr>
                        <td>Community Health Workers/Orderlies</td>
                        <td>{{ $hospital->community_health_workers }}</td>
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
                        <td>{{ $hospital->health_extension_officers }}</td>
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
