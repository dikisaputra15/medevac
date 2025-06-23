@extends('layouts.master')

@section('title','Emergency Support')

@push('styles')

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #fbeeee;">
        <div class="d-flex gap-2">
            <!-- Button 1 -->
            <a href="{{ url('hospital') }}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

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

            <!-- Button 7 -->
            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
            <i class="bi bi-bank fs-3"></i>
                <small>Embassies</small>
            </a>
        </div>
    </div>

    <div class="card-header bg-white">
        <h3>{{ $hospital->name }} - Papua New Guinea <small><i>Last Updated</i></small></h3>
        <small><i>{{ $hospital->created_at->format('M Y') }}</i></small>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-plane-arrival"></i><b>Nearest Airport</b></h2>
                    <?php echo $hospital->nearest_airfield; ?>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-user-shield"></i><b>Nearest Police Station</b></h2>
                    <?php echo $hospital->nearest_police_station; ?>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-notes-medical"></i> <b>Medical Support Websites</b></h2>
                    <?php echo $hospital->medical_support_website; ?>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-shuttle-van"></i> <b>Local Travel Support</b></h2>
                    <?php echo $hospital->travel_agent; ?>
            </div>
            </div>
        </div>
    </div>

</div>


@endsection

@push('service')

@endpush
