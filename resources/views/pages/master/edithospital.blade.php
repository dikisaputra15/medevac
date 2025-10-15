@extends('layouts.master-admin')

@section('title','Edit Hospital')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Edit Hospital</h3>
    </div>

<form action="{{ route('hospitaldata.update', $hospital->id) }}" enctype="multipart/form-data" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Hospital Name</label>
                <input type="text" class="form-control" name="name" value="{{ $hospital->name; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Address</label>
                <input type="text" class="form-control" name="address" value="{{ $hospital->address; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Provinces, Region</label>
                <select class="form-control" name="province_id">
                    <?php
                        foreach ($provinces as $prov) {

                            if ($prov->id==$hospital->province_id) {
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
                <label>Edit Latitude</label>
                <input type="text" class="form-control" name="latitude" value="{{ $hospital->latitude; }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Longitude</label>
                <input type="text" class="form-control" name="longitude" value="{{ $hospital->longitude; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Facility Level</label>
                <select class="form-control" name="facility_level">
                    <option value="1 - Village Health Post (VHP)" {{ old('facility_level', $hospital->facility_level ?? '') == '1 - Village Health Post (VHP)' ? 'selected' : '' }}>
                        1 - Village Health Post (VHP)
                    </option>
                    <option value="2 - Community Health Post (CHP)" {{ old('facility_level', $hospital->facility_level ?? '') == '2 - Community Health Post (CHP)' ? 'selected' : '' }}>
                        2 - Community Health Post (CHP)
                    </option>
                    <option value="3 - Health Center / Urban Clinic (HC-UC)" {{ old('facility_level', $hospital->facility_level ?? '') == '3 - Health Center / Urban Clinic (HC-UC)' ? 'selected' : '' }}>
                        3 - Health Center / Urban Clinic (HC-UC)
                    </option>
                    <option value="4 - District Hospital - Rural Health Services (DH)" {{ old('facility_level', $hospital->facility_level ?? '') == '4 - District Hospital - Rural Health Services (DH)' ? 'selected' : '' }}>
                        4 - District Hospital - Rural Health Services (DH)
                    </option>
                    <option value="5 - Provincial Hospital, Health Services and Public Health Programs (PHA)" {{ old('facility_level', $hospital->facility_level ?? '') == '5 - Provincial Hospital, Health Services and Public Health Programs (PHA)' ? 'selected' : '' }}>
                        5 - Provincial Hospital, Health Services and Public Health Programs (PHA)
                    </option>
                    <option value="6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)" {{ old('facility_level', $hospital->facility_level ?? '') == '6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)' ? 'selected' : '' }}>
                        6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)
                    </option>
                </select>
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Hospital Classification Group</label><br>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Advanced"
                        {{ old('Advanced', $hospital->facility_category ?? '') == 'Advanced' ? 'checked' : '' }}>
                    <label class="form-check-label">Advanced</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Intermediete"
                        {{ old('Intermediete', $hospital->facility_category ?? '') == 'Intermediete' ? 'checked' : '' }}>
                    <label class="form-check-label">Intermediete</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Basic"
                        {{ old('Basic', $hospital->facility_category ?? '') == 'Basic' ? 'checked' : '' }}>
                    <label class="form-check-label">Basic</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Specialized"
                        {{ old('Specialized', $hospital->facility_category ?? '') == 'Specialized' ? 'checked' : '' }}>
                    <label class="form-check-label">Specialized</label>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Icon</label><br>

                @php
                    $icons = [
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png', 'label' => 'Level 1'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png', 'label' => 'Level 2'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png', 'label' => 'Level 3'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png', 'label' => 'Level 4'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png', 'label' => 'Level 5'],
                        ['url' => 'https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png', 'label' => 'Level 6'],
                    ];
                @endphp

                @foreach($icons as $icon)
                    <label style="margin-right: 15px;">
                        <input type="radio" name="icon" value="{{ $icon['url'] }}"
                            @checked(old('icon', $hospital->icon ?? '') === $icon['url'])>
                        <img src="{{ $icon['url'] }}" style="width:24px; height:24px;"> {{ $icon['label'] }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit status</label>
                <input type="text" class="form-control" name="status" value="{{ $hospital->status; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Number Of Beds</label>
                <input type="text" class="form-control" name="number_of_beds" value="{{ $hospital->number_of_beds; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Population Catchment</label>
                <input type="text" class="form-control" name="population_catchment" value="{{ $hospital->population_catchment; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Ownership</label>
                <input type="text" class="form-control" name="ownership" value="{{ $hospital->ownership; }}">
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

                <textarea id="summernote4" name="hrs_of_operation">
                    <?php echo $hospital->hrs_of_operation; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Other Medical Info
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote13" name="other_medical_info">
                    <?php echo $hospital->other_medical_info; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Telephone
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote5" name="telephone">
                    <?php echo $hospital->telephone; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Fax
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote6" name="fax">
                    <?php echo $hospital->fax; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Email
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote7" name="email">
                    <?php echo $hospital->email; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Website
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote8" name="website">
                    <?php echo $hospital->website; ?>
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

                <textarea id="summernote11" name="nearest_accommodation">
                    <?php echo $hospital->nearest_accommodation; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Inpatient Services</label>
                <input type="text" class="form-control" name="inpatient_services" value="{{ $hospital->inpatient_services; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Outpatient Services</label>
                <input type="text" class="form-control" name="outpatient_services" value="{{ $hospital->outpatient_services; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Hour Emergency Services</label>
                <input type="text" class="form-control" name="hour_emergency_services" value="{{ $hospital->hour_emergency_services; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Ambulance</label>
                <input type="text" class="form-control" name="ambulance" value="{{ $hospital->ambulance; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Helipad</label>
                <input type="text" class="form-control" name="helipad" value="{{ $hospital->helipad; }}">
            </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Comments
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote10" name="comments">
                    <?php echo $hospital->comments; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit ICU</label>
                <input type="text" class="form-control" name="icu" value="{{ $hospital->icu; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Medical</label>
                <input type="text" class="form-control" name="medical" value="{{ $hospital->medical; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Pediatric</label>
                <input type="text" class="form-control" name="pediatric" value="{{ $hospital->pediatric; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Maternal</label>
                <input type="text" class="form-control" name="maternal" value="{{ $hospital->maternal; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Dental</label>
                <input type="text" class="form-control" name="dental" value="{{ $hospital->dental; }}">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Edit Optical</label>
                <input type="text" class="form-control" name="optical" value="{{ $hospital->optical; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit IOC</label>
                <input type="text" class="form-control" name="ioc" value="{{ $hospital->ioc; }}">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Edit Laboratory</label>
                <input type="text" class="form-control" name="laboratory" value="{{ $hospital->laboratory; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Pharmacy</label>
                <input type="text" class="form-control" name="pharmacy" value="{{ $hospital->pharmacy; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Medical Imaging</label>
                <input type="text" class="form-control" name="medical_imaging" value="{{ $hospital->medical_imaging; }}">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Edit Medical Student Training</label>
                <input type="text" class="form-control" name="medical_student_training" value="{{ $hospital->medical_student_training; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Doctors</label>
                <input type="text" class="form-control" name="doctors" value="{{ $hospital->doctors; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Nurses</label>
                <input type="text" class="form-control" name="nurses" value="{{ $hospital->nurses; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Dental Therapist</label>
                <input type="text" class="form-control" name="dental_therapist" value="{{ $hospital->dental_therapist; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Laboratory Assistants</label>
                <input type="text" class="form-control" name="laboratory_assistants" value="{{ $hospital->laboratory_assistants; }}">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Edit Community Health</label>
                <input type="text" class="form-control" name="community_health" value="{{ $hospital->community_health; }}">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Edit Health Inspectors</label>
                <input type="text" class="form-control" name="health_inspectors" value="{{ $hospital->health_inspectors; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Malaria Control Officers</label>
                <input type="text" class="form-control" name="malaria_control_officers" value="{{ $hospital->malaria_control_officers; }}">
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Health Extention officer</label>
                <input type="text" class="form-control" name="health_extention_officers" value="{{ $hospital->health_extention_officers; }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Edit Casuals</label>
                <input type="text" class="form-control" name="casuals" value="{{ $hospital->casuals; }}">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Edit Others</label>
                <input type="text" class="form-control" name="others" value="{{ $hospital->others; }}">
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

                <textarea id="summernote" name="nearest_police_station">
                    <?php echo $hospital->nearest_police_station; ?>
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Medical Support Website
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote9" name="medical_support_website">
                    <?php echo $hospital->medical_support_website; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Evacuation Option
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote3" name="evacuation_option">
                    <?php echo $hospital->evacuation_option; ?>
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Nearest Airport
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote2" name="nearest_airport">
                    <?php echo $hospital->nearest_airfield; ?>
                </textarea>

            </div>

          </div>
        </div>

          <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Travel Agent
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote12" name="travel_agent">
                    <?php echo $hospital->travel_agent; ?>
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

  })
</script>
@endpush
