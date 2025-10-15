@extends('layouts.master-admin')

@section('title','Add Hospital')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Add Hospital</h3>
    </div>

<form action="{{ route('hospitaldata.store') }}" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="card-body">

        <div class="col-md-12">
            <div class="form-group">
                <label>Hospital Name</label>
                <input type="text" class="form-control" name="name">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Provinces, Region</label>
                <select class="form-control" name="province_id">
                        <option value="0">-Choosse Provinces Region-</option>
                    @foreach($provinces as $prov)
                        <option value="{{$prov->id}}">{{$prov->provinces_region}}</option>
                    @endforeach
                </select>
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Address</label>
                <input type="text" class="form-control" name="address">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Latitude</label>
                <input type="text" class="form-control" name="latitude">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Longitude</label>
                <input type="text" class="form-control" name="longitude">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Facility Level</label>
                <select class="form-control" name="facility_level">
                    <option value="1 - Village Health Post (VHP)">
                        1 - Village Health Post (VHP)
                    </option>
                    <option value="2 - Community Health Post (CHP)">
                        2 - Community Health Post (CHP)
                    </option>
                    <option value="3 - Health Center / Urban Clinic (HC-UC)">
                        3 - Health Center / Urban Clinic (HC-UC)
                    </option>
                    <option value="4 - District Hospital - Rural Health Services (DH)">
                        4 - District Hospital - Rural Health Services (DH)
                    </option>
                    <option value="5 - Provincial Hospital, Health Services and Public Health Programs (PHA)">
                        5 - Provincial Hospital, Health Services and Public Health Programs (PHA)
                    </option>
                    <option value="6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)">
                        6 - National Referral Specialist - Tertiary Teaching Hospital - Health Services (NHA)
                    </option>
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Hospital Classification Group</label><br>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Advanced">
                    <label class="form-check-label">Advanced</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Intermediete">
                    <label class="form-check-label">Intermediete</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Basic">
                    <label class="form-check-label">Basic</label>
                </div>

                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="facility_category" value="Specialized">
                    <label class="form-check-label">Specialized</label>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Icon</label>
                <input type="radio" name="icon" value="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png"><img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-tosca.png" style="width:24; height:24;"> Level 1
                <input type="radio" name="icon" value="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png"><img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-orange.png" style="width:24; height:24;"> Level 2
                <input type="radio" name="icon" value="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png"><img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-green.png" style="width:24; height:24;"> Level 3
                <input type="radio" name="icon" value="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png"><img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-purple.png" style="width:24; height:24;"> Level 4
                <input type="radio" name="icon" value="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png"><img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital_pin-blue.png" style="width:24; height:24;"> Level 5
                <input type="radio" name="icon" value="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png"><img src="https://pg.concordreview.com/wp-content/uploads/2025/01/hospital-pin-red.png" style="width:24; height:24;"> Level 6
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>status</label>
                <input type="text" class="form-control" name="status">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Number Of Beds</label>
                <input type="text" class="form-control" name="number_of_beds">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Population Catchment</label>
                <input type="text" class="form-control" name="population_catchment">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Ownership</label>
                <input type="text" class="form-control" name="ownership">
            </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Hours Of Operation
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote4" name="hrs_of_operation">

                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Other Medical Info
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote13" name="other_medical_info">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Telephone
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote5" name="telephone">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Fax
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote6" name="fax">

                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Email
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote7" name="email">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Website
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote8" name="website">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Nearest Accommodation
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote11" name="nearest_accommodation">
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Inpatient Services</label>
                <input type="text" class="form-control" name="inpatient_services">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Outpatient Services</label>
                <input type="text" class="form-control" name="outpatient_services">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Hour Emergency Services</label>
                <input type="text" class="form-control" name="hour_emergency_services">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Ambulance</label>
                <input type="text" class="form-control" name="ambulance">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Helipad</label>
                <input type="text" class="form-control" name="helipad">
            </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Comments
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote10" name="comments">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>ICU</label>
                <input type="text" class="form-control" name="icu">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Medical</label>
                <input type="text" class="form-control" name="medical">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Pediatric</label>
                <input type="text" class="form-control" name="pediatric">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Maternal</label>
                <input type="text" class="form-control" name="maternal">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Dental</label>
                <input type="text" class="form-control" name="dental">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Optical</label>
                <input type="text" class="form-control" name="optical">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>IOC</label>
                <input type="text" class="form-control" name="ioc">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Laboratory</label>
                <input type="text" class="form-control" name="laboratory">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Pharmacy</label>
                <input type="text" class="form-control" name="pharmacy">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Medical Imaging</label>
                <input type="text" class="form-control" name="medical_imaging">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Medical Student Training</label>
                <input type="text" class="form-control" name="medical_student_training">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Doctors</label>
                <input type="text" class="form-control" name="doctors">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Nurses</label>
                <input type="text" class="form-control" name="nurses">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Dental Therapist</label>
                <input type="text" class="form-control" name="dental_therapist">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Laboratory Assistants</label>
                <input type="text" class="form-control" name="laboratory_assistants">
            </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Community Health</label>
                <input type="text" class="form-control" name="community_health">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Health Inspectors</label>
                <input type="text" class="form-control" name="health_inspectors">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Malaria Control Officers</label>
                <input type="text" class="form-control" name="malaria_control_officers">
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label>Health Extention officer</label>
                <input type="text" class="form-control" name="health_extention_officers">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label>Casuals</label>
                <input type="text" class="form-control" name="casuals">
            </div>
        </div>

          <div class="col-md-12">
            <div class="form-group">
                <label>Others</label>
                <input type="text" class="form-control" name="others">
            </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Nearest Police Station
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote" name="nearest_police_station">
                </textarea>

            </div>

          </div>
        </div>

        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Medical Support Website
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote9" name="medical_support_website">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Evacuation Option
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote3" name="evacuation_option">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Nearest Airport
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote2" name="nearest_airport">
                </textarea>

            </div>

          </div>
        </div>

          <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Travel Agent
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote12" name="travel_agent">
                </textarea>

            </div>

          </div>
        </div>

         <div class="col-md-12">
            <div class="form-group">
                <label>Image</label>
                <input type="file" class="form-control" name="image">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
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
