@extends('layouts.master')

@section('title','More Details')
@section('page-title', 'Papua New Guinea Medical Facility')

@push('styles')

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />

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
    }

    .mb-4{
        margin-bottom: 0.5rem !important;
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

            <a href="{{ url('hospitals') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-file-earmark-text-fill fs-3"></i>
                <small>General</small>
            </a>

            <a href="{{ url('hospitals/clinic') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/clinic/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-hospital fs-3"></i>
                <small>Clinical Services</small>
            </a>

            <a href="{{ url('hospitals/emergency') }}/{{$hospital->id}}" class="btn btn-outline-danger d-flex flex-column align-items-center p-3 {{ request()->is('hospitals/emergency/'.$hospital->id) ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill fs-3"></i>
                <small>Emergency Support</small>
            </a>
            <a href="{{ url('airports') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('airports') ? 'active' : '' }}">
                <i class="bi bi-airplane fs-3"></i>
                <small>Airports</small>
            </a>

            <a href="{{ url('aircharter') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('aircharter') ? 'active' : '' }}">
                <i class="bi bi-airplane-engines fs-3"></i>
                <small>Air Charter</small>
            </a>

            <a href="{{ url('embassiees') }}" class="btn btn-danger d-flex flex-column align-items-center p-3 {{ request()->is('embassiees') ? 'active' : '' }}">
            <i class="bi bi-bank fs-3"></i>
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
        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-notes-medical"></i> General Medical Facility Info</div>
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
                        <strong>Other Medical Services Info:</strong> <?php echo $hospital->other_medical_info; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-map-marker-alt"></i> Location</div>
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
                <div class="card-header fw-bold"><i class="fas fa-phone"></i> Contact Details</div>
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
                <div class="card-header fw-bold"><i class="fas fa-hotel"></i>  Nearest Accommodation</div>
                <div class="card-body overflow-auto">
                    <?php echo $hospital->nearest_accommodation; ?>
                </div>
            </div>

        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header fw-bold"><i class="fas fa-map"></i>Nearby Hospital (Up To 100 KM)</div>
                <div class="card-body p-0">
                    <div id="map"></div>
                </div>
            </div>

            <div class="card">
                <div class="d-flex justify-content-between align-items-center" style="margin-bottom:0; margin-top:0;">
                    <div class="d-flex align-items-center">

                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level66Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24px; height:24px;">
                            <small>Level 6</small>
                        </button>

                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level55Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24px; height:24px;">
                            <small>Level 5</small>
                        </button>

                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level44Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:24px; height:24px;">
                            <small>Level 4</small>
                        </button>

                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level33Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24px; height:24px;">
                            <small>Level 3</small>
                        </button>

                        <button class="btn p-1" data-bs-toggle="modal" data-bs-target="#level22Modal">
                            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:24px; height:24px;">
                            <small>Level 2</small>
                        </button>

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

<div class="modal fade" id="level11Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 1</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Village Health Post – Aid Post (VHP)</b></p>
        <p class="p-modal">Basic level primary health care including health promotion, health improvement, and health protection.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level22Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 2</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Community Health Post - Health Sub Center (CHP)</b></p>
        <p class="p-modal">Primary health, ambulatory care, and short stay inpatient and maternity care at the local rural / remote community level, with a minimum of six (6) health workers to ensure safe 24-hour care and treatment.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level33Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 3</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Health Center - Rural / Urban Clinic – Urban Centers (HC-UC)</b></p>
        <p class="p-modal">Primary health and ambulatory care in urban and rural settings, inpatient, maternity, and newborn care in major provincial urban communities.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level44Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
         <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 4</h5>
         </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>District Hospital - Rural Health Services (DH)</b></p>
        <p class="p-modal">Primary and secondary level clinical services and district wide public health programs.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level55Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 5</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>Provincial Hospital, Health Services and Public Health Programs (PHA)</b></p>
        <p class="p-modal">Secondary level & specialist clinical care services, supporting primary health care, integrating public health programs, and patient referral.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="level66Modal" tabindex="-1" aria-labelledby="disclaimerLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div class="d-flex align-items-center">
            <img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:30px; height:30px;">
            <h5 class="modal-title" id="disclaimerLabel">Class 6</h5>
        </div>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><b>National Referral Specialist Tertiary and Teaching Hospital - Health Services (NHA)</b></p>
        <p class="p-modal">Complex tertiary level clinical services, supporting primary health care, public health programs, and a formalized patient referral arrangement.</p>
      </div>
    </div>
  </div>
</div>

@endsection

@push('service')
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.fullscreen/Control.FullScreen.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', () => {
        const hospitalData = {
            id: {{ $hospital->id }},
            name: '{{ $hospital->name }}',
            latitude: {{ $hospital->latitude }},
            longitude: {{ $hospital->longitude }},
            image: '{{ $hospital->image ?? '' }}',
            address: '{{ $hospital->address ?? '' }}',
            telephone: '{{ $hospital->telephone ?? '' }}',
            website: '{{ $hospital->website ?? '' }}',
            icon: '{{ $hospital->icon ?? '' }}'
        };
        const nearbyHospitals = @json($nearbyHospitals);
        const radiusKm = {{ $radius_km }};

        let map;
        let mainMarker;
        let nearbyMarkersGroup = L.featureGroup();
        let radiusCircle;
        let routingControl; // simpan rute aktif

        const DEFAULT_HOSPITAL_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-blue.png';
        const DEFAULT_MAIN_HOSPITAL_ICON_URL = 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png';

        const mainHospitalIcon = new L.Icon({
            iconUrl: DEFAULT_MAIN_HOSPITAL_ICON_URL,
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        function initializeMap() {
            map = L.map('map', { fullscreenControl: true })
                .setView([hospitalData.latitude, hospitalData.longitude], 12);

            const osmLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 19
            });

            const satelliteLayer = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
                { attribution: 'Tiles &copy; Esri', maxZoom: 19 }
            );

            satelliteLayer.addTo(map);

            L.control.layers({
                "Satelit Map": satelliteLayer,
                "Street Map": osmLayer
            }).addTo(map);

            nearbyMarkersGroup.addTo(map);
        }

        function addMainHospitalAndCircle() {
            mainMarker = L.marker([hospitalData.latitude, hospitalData.longitude], { icon: mainHospitalIcon })
                .addTo(map)
                .bindPopup(`<b>${hospitalData.name}</b><br>This is the main hospital.`)
                .openPopup();

            radiusCircle = L.circle([hospitalData.latitude, hospitalData.longitude], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.2,
                radius: radiusKm * 1000
            }).addTo(map);
        }

        function addNearbyHospitals(data) {
            data.forEach(item => {
                const itemIcon = L.icon({
                    iconUrl: item.icon || DEFAULT_HOSPITAL_ICON_URL,
                    iconSize: [24, 24],
                    iconAnchor: [12, 24],
                    popupAnchor: [0, -20]
                });

                const marker = L.marker([item.latitude, item.longitude], { icon: itemIcon });

                const name = item.name || 'N/A';
                const detailUrl = `/hospitals/${item.id}`;
                const distance = item.distance ? `<br><strong>Distance:</strong> ${item.distance.toFixed(2)} km` : '';

                marker.bindPopup(`
                    <b><a href="${detailUrl}">${name}</a></b> (Hospital)<br>
                    ${distance}
                    <br>
                    <button class="btn btn-sm btn-primary mt-2" onclick="getDirection(${item.latitude}, ${item.longitude}, '${name}')">
                        Get Direction
                    </button>
                `);

                nearbyMarkersGroup.addLayer(marker);
            });
        }

        function fitMapToBounds() {
            const bounds = L.featureGroup([mainMarker, nearbyMarkersGroup, radiusCircle]).getBounds();
            if (bounds.isValid()) {
                map.fitBounds(bounds, { padding: [50, 50] });
            }
        }

        // === Get Direction Function ===
        window.getDirection = function(lat, lng, name) {
            if (routingControl) {
                map.removeControl(routingControl);
            }

            routingControl = L.Routing.control({
                waypoints: [
                    L.latLng(hospitalData.latitude, hospitalData.longitude), // asal
                    L.latLng(lat, lng) // tujuan
                ],
                routeWhileDragging: true,
                show: false,
                createMarker: function(i, wp, nWps) {
                    if (i === 0) {
                        return L.marker(wp.latLng, { icon: mainHospitalIcon })
                            .bindPopup(`<b>${hospitalData.name}</b><br>Start Point`);
                    } else if (i === nWps - 1) {
                        return L.marker(wp.latLng)
                            .bindPopup(`<b>${name}</b><br>Destination`);
                    }
                }
            }).addTo(map);
        };

        // --- Main execution ---
        initializeMap();
        addMainHospitalAndCircle();
        addNearbyHospitals(nearbyHospitals);
        fitMapToBounds();
    });
</script>

@endpush
