@extends('layouts.master')

@section('title','More Details')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<style>
    #map {
        height: 700px;
    }
</style>

@endpush

@section('conten')

<div class="card">

    <div class="d-flex justify-content-between p-3" style="background-color: #fbeeee;">
        <div class="d-flex gap-2">
            <!-- Button 1 -->
            <a href="{{ url('airports') }}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-house-door-fill fs-3"></i>
                <small>Home</small>
            </a>

            <!-- Button 2 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/detail" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <!-- Button 3 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/navigation" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-compass fs-3"></i>
                <small>Navigation</small>
            </a>

             <!-- Button 4 -->
             <a href="{{ url('airports') }}/{{$airport->id}}/airlinesdestination" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Airlines/Destination</small>
            </a>

            <!-- Button 5 -->
            <a href="{{ url('airports') }}/{{$airport->id}}/emergency" class="btn btn-outline-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>

        </div>

        <div class="d-flex gap-2 ms-auto">
            <!-- Button 5 -->
            <a href="{{ url('hospital') }}" class="btn btn-danger d-flex flex-column align-items-center p-3">
                <i class="bi bi-hospital fs-3"></i>
                <small>Medical Facilities</small>
            </a>

            <!-- Button 6 -->
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

    <div class="card-header bg-white">
        <h3>{{ $airport->airport_name }}</h3>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-plane-arrival"></i><b>Communication</b></h2>
                <table class="table">
                    <tr>
                        <td>Tower</td>
                        <td>Freq (Mhz)</td>
                    </tr>
                    @foreach($airportcommunications as $acom)
                        <tr>
                            <td>{{ $acom->tower }}</td>
                            <td>{{ $acom->frequensi }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-user-shield"></i><b>Runway</b></h2>
                <table class="table">
                    <tr>
                        <td>Runway Edge Lights</td>
                        <td>Runway End Identifier Lights</td>
                        <td>Runway</td>
                        <td>Dimensions</td>
                        <td>Surface</td>
                        <td>Latitude</td>
                        <td>Longitude</td>
                        <td>Elevation</td>
                        <td>True Heading</td>
                    </tr>
                    @foreach($runawayairports as $run)
                        <tr>
                            <td>{{ $run->runway_edge_light }}</td>
                            <td>{{ $run->runway_enidentifier_light }}</td>
                            <td>{{ $run->runway }}</td>
                            <td>{{ $run->dimension }}</td>
                            <td>{{ $run->surface }}</td>
                            <td>{{ $run->latitude }}</td>
                            <td>{{ $run->longitude }}</td>
                            <td>{{ $run->elevation }}</td>
                            <td>{{ $run->true_heading }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card">
            <div class="card-body">
                <h2><i class="bi bi-airplane fs-3"></i> <b>Navigation Aids for nearby airports</b></h2>
                <table class="table">
                    <tr>
                        <td>Dist NM</td>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Type</td>
                        <td>Freq (Mhz)</td>
                        <td>True Hdg</td>
                        <td>Mag Hdg</td>
                    </tr>
                    @foreach($navigationnearbyairports as $navner)
                        <tr>
                            <td>{{ $navner->dist_nm }}</td>
                            <td>{{ $navner->name_id_airport }}</td>
                            <td>{{ $navner->name }}</td>
                            <td>{{ $navner->type }}</td>
                            <td>{{ $navner->freq_mhz }}</td>
                            <td>{{ $navner->true_hdg }}</td>
                            <td>{{ $navner->mag_hdg }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
            <div class="card-body">
                <h2><i class="fas fa-plane-arrival"></i><b>Navigation Aids (NAVAIDs)</b></h2>
                <table class="table">
                    <tr>
                        <td>Code</td>
                        <td>Type</td>
                        <td>Frequency</td>
                        <td>Channel</td>
                        <td>Usage</td>
                        <td>Radio Class</td>
                        <td>Power</td>
                        <td>Range</td>
                        <td>Latitude</td>
                        <td>Longitude</td>
                        <td>Elevation</td>
                        <td>Magnetic Variation</td>
                        <td>World Area Code</td>
                        <td>Associated Airport</td>
                    </tr>
                    @foreach($navigationaidairports as $navaid)
                        <tr>
                            <td>{{ $navaid->code }}</td>
                            <td>{{ $navaid->type }}</td>
                            <td>{{ $navaid->frequency }}</td>
                            <td>{{ $navaid->chanel }}</td>
                            <td>{{ $navaid->usage }}</td>
                            <td>{{ $navaid->radio_class }}</td>
                            <td>{{ $navaid->power }}</td>
                            <td>{{ $navaid->range }}</td>
                            <td>{{ $navaid->latitude }}</td>
                            <td>{{ $navaid->longitude }}</td>
                            <td>{{ $navaid->elevation }}</td>
                            <td>{{ $navaid->magnetic_variation }}</td>
                            <td>{{ $navaid->world_area_code }}</td>
                            <td>{{ $navaid->associated_airport }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
            </div>
        </div>

    </div>

</div>


@endsection

@push('service')

@endpush
