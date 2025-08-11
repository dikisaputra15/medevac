@extends('layouts.master')

@section('title','Edit Airport')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Edit Airport</h3>
    </div>

<form action="{{ route('airportdata.update', $airport->id) }}" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Airport Name</label>
                <input type="text" class="form-control" name="airport_name" value="{{ $airport->airport_name; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Provinces, Region</label>
                <select class="form-control" name="province_id">
                    <?php
                        foreach ($provinces as $prov) {

                            if ($prov->id==$airport->province_id) {
                                $select="selected";
                            }else{
                                $select="";
                            }

                        ?>
                            <option <?php echo $select; ?> value="<?php echo $prov->id;?>"><?php echo $prov->provinces_region; ?></option>

                    <?php } ?>

                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Address</label>
                <input type="text" class="form-control" name="address" value="{{ $airport->address; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Latitude</label>
                <input type="text" class="form-control" name="latitude" value="{{ $airport->latitude; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Longitude</label>
                <input type="text" class="form-control" name="longitude" value="{{ $airport->longitude; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Telephone</label>
                <input type="text" class="form-control" name="telephone" value="{{ $airport->telephone; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Fax</label>
                <input type="text" class="form-control" name="fax" value="{{ $airport->fax; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Email</label>
                <input type="text" class="form-control" name="email" value="{{ $airport->email; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Website</label>
                <input type="text" class="form-control" name="website" value="{{ $airport->website; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Category</label>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="international" value="International"
                        {{ in_array('International', $category) ? 'checked' : '' }}>
                    <label class="form-check-label" for="international">International</label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="domestic" value="Domestic"
                        {{ in_array('Domestic', $category) ? 'checked' : '' }}>
                    <label class="form-check-label" for="domestic">Domestic</label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="regionaldomestic" value="Regional Domestic"
                        {{ in_array('Regional Domestic', $category) ? 'checked' : '' }}>
                    <label class="form-check-label" for="regional domestic">Regional Domestic</label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="military" value="Military"
                        {{ in_array('Military', $category) ? 'checked' : '' }}>
                    <label class="form-check-label" for="military">Military</label>
                </div>
                 <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="combined" value="Combined"
                        {{ in_array('Combined', $category) ? 'checked' : '' }}>
                    <label class="form-check-label" for="combined">Combined (Civil - Military)</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="private" value="Private"
                        {{ in_array('Private', $category) ? 'checked' : '' }}>
                    <label class="form-check-label" for="private">Private</label>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit IATA Code</label>
                <input type="text" class="form-control" name="iata_code" value="{{ $airport->iata_code; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit ICAO Code</label>
                <input type="text" class="form-control" name="icao_code" value="{{ $airport->icao_code; }}">
            </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Hours Of Operation
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote6" name="hrs_of_operation">
                    <?php echo $airport->hrs_of_operation; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Distance From
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote7" name="distance_from">
                    <?php echo $airport->distance_from; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Time Zone</label>
                <input type="text" class="form-control" name="time_zone" value="{{ $airport->time_zone; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Elevation</label>
                <input type="text" class="form-control" name="elevation" value="{{ $airport->elevation; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Operator</label>
                <input type="text" class="form-control" name="operator" value="{{ $airport->operator; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Magnetic Variation</label>
                <input type="text" class="form-control" name="magnetic_variation" value="{{ $airport->magnetic_variation; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Beacon</label>
                <input type="text" class="form-control" name="beacon" value="{{ $airport->beacon; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Max Aircraft Capability</label>
                <input type="text" class="form-control" name="max_aircraft_capability" value="{{ $airport->max_aircraft_capability; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Air Traffic</label>
                <input type="text" class="form-control" name="air_traffic" value="{{ $airport->air_traffic; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Meteorology Services</label>
                <input type="text" class="form-control" name="meteorology_services" value="{{ $airport->meteorology_services; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Aviation Fuel Depot</label>
                <input type="text" class="form-control" name="aviation_fuel_depot" value="{{ $airport->aviation_fuel_depot; }}">
            </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Supplies Eqipment
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote8" name="supplies_eqipment">
                    <?php echo $airport->supplies_eqipment; ?>
                </textarea>

            </div>

          </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Edit Internet Services</label>
                <input type="text" class="form-control" name="internet_services" value="{{ $airport->internet_services; }}">
            </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Public Facilities
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote9" name="public_facilities">
                    <?php echo $airport->public_facilities; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Public Transportation
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote10" name="public_transportation">
                    <?php echo $airport->public_transportation; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Note
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote11" name="note">
                    <?php echo $airport->note; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Nearest Accommodation
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote12" name="nearest_accommodation">
                    <?php echo $airport->nearest_accommodation; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Other Flight Information
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote13" name="other_flight_information">
                    <?php echo $airport->other_flight_information; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Other Reference Website
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote14" name="other_reference_website">
                    <?php echo $airport->other_reference_website; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Flight Information
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote15" name="flight_information">
                    <?php echo $airport->flight_information; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit International Flight
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote16" name="international_flight">
                    <?php echo $airport->international_flight; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Domestic Airlines / Destination
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote4" name="domestic_flights">
                    <?php echo $airport->domestic_flights; ?>
                </textarea>

            </div>

          </div>
        </div>

          <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Nearest Medical Facility
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote5" name="nearest_medical_facility">
                    <?php echo $airport->nearest_medical_facility; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Nearest Airports
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote" name="nearest_airport">
                    <?php echo $airport->nearest_airport; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Runway Edge Lights</label>
                <input type="text" class="form-control" name="runway_edge_lights" value="{{ $airport->runway_edge_lights; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Reil</label>
                <input type="text" class="form-control" name="reil" value="{{ $airport->reil; }}">
            </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Runways
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote17" name="runways">
                    <?php echo $airport->runways; ?>
                </textarea>

            </div>

          </div>
        </div>

       <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Navigation Aids (NAVAIDs)
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote2" name="navigation_aids">
                    <?php echo $airport->navigation_aids; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Nearby Airport Navigation Aids
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote19" name="nearby_airport_navigation_aids">
                    <?php echo $airport->nearby_airport_navigation_aids; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Communication
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote18" name="communication">
                    <?php echo $airport->communication; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Nearest Police Station
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote3" name="nearest_police_station">
                    <?php echo $airport->nearest_police_station; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Image</label>
                <input type="file" class="form-control" name="image">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Icon</label><br>

                @php
                    $icons = [
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2024/10/International-Airport.png', 'label' => 'International'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/regional-airport.png', 'label' => 'Domestic'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/regional-domestic-airport.png', 'label' => 'Regional Domestic'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2024/10/military-airport-red.png', 'label' => 'Military'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2024/10/civil-military-airport.png', 'label' => 'Combined (Civil - Military)'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/private-airport.png', 'label' => 'Private'],
                    ];
                @endphp

                @foreach($icons as $icon)
                    <label style="margin-right: 15px;">
                        <input type="radio" name="icon" value="{{ $icon['url'] }}"
                            @checked(old('icon', $airport->icon ?? '') === $icon['url'])>
                        <img src="{{ $icon['url'] }}" style="width:24px; height:24px;"> {{ $icon['label'] }}
                    </label>
                @endforeach
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Update Data</button>
    </div>
</form>
</div>
@endsection

@push('service')
<script>
  $(function () {
    // Summernote
    $('#summernote').summernote()
    $('#summernote2').summernote()
    $('#summernote3').summernote()
    $('#summernote4').summernote()
    $('#summernote5').summernote()
    $('#summernote6').summernote()
    $('#summernote7').summernote()
    $('#summernote8').summernote()
    $('#summernote9').summernote()
    $('#summernote10').summernote()
    $('#summernote11').summernote()
    $('#summernote12').summernote()
    $('#summernote13').summernote()
    $('#summernote14').summernote()
    $('#summernote15').summernote()
    $('#summernote16').summernote()
    $('#summernote17').summernote()
    $('#summernote18').summernote()
    $('#summernote19').summernote()

  })
</script>
@endpush
