@extends('layouts.master')

@section('title','Dashboard')

@push('styles')



@endpush

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3 style="text-align: center;">Medical Evacuation</h3>
        <h3 style="text-align: center;">Papua New Guinea Hospital, Airport, Embassy</h3>
    </div>
</div>

 <div class="row justify-content-center">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $totalhospital }}</h3>

                <p>Hospital</p>
              </div>
              <div class="icon">
                 <i class="ion ion-pie-graph"></i>
              </div>

            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $totalairport }}</h3>

                <p>Airport</p>
              </div>
              <div class="icon">
                 <i class="ion ion-pie-graph"></i>
              </div>

            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $totalembassy }}</h3>

                <p>Embassy</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>

            </div>
          </div>
</div>


@endsection

@push('service')

@endpush
