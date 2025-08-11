@extends('layouts.master')

@section('title','Emergency Support')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')
<style>
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
</style>
@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #dfeaf1;">
        <div class="d-flex gap-2 align-items-center">
            <h2 class="fw-bold">{{ $hospital->name }}</h2>
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

     <div class="card mb-4 d-flex flex-column gap-3">
        <div class="card-body overflow-auto" style="max-height: 350px;">
             <small><i>Last Updated</i></small>
             <small><i>{{ $hospital->created_at->format('M Y') }}</i></small>
        </div>
    </div>

    <div class="row">

         <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card h-100">
              <div class="card-header fw-bold"><i class="fas fa-notes-medical"></i>Medical Support Websites</div>
              <div class="card-body overflow-auto" style="max-height: 350px;">
                    <?php echo $hospital->medical_support_website; ?>
            </div>
            </div>
        </div>

        <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card h-100">
            <div class="card-header fw-bold"><i class="fas fa-shuttle-van"></i>Local Travel Support</div>
              <div class="card-body overflow-auto" style="max-height: 350px;">
                    <?php echo $hospital->travel_agent; ?>
            </div>
            </div>

            <div class="card h-100">
                <div class="card-header fw-bold"><i class="fas fa-plane-arrival"></i>Nearest Airport</div>
              <div class="card-body overflow-auto" style="max-height: 350px;">
                      <?php echo $hospital->nearest_airfield; ?>
            </div>
            </div>
        </div>

          <div class="col-sm-4 d-flex flex-column gap-3">
            <div class="card h-100">
              <div class="card-header fw-bold"><i class="fas fa-user-shield"></i>Nearest Police station</div>
             <div class="card-body overflow-auto" style="max-height: 350px;">
                    <?php echo $hospital->nearest_police_station; ?>
            </div>
            </div>
        </div>

    </div>

</div>


@endsection

@push('service')

@endpush
