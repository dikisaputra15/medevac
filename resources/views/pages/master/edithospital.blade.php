@extends('layouts.master')

@section('title','Edit Hospital')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Edit Hospital</h3>
    </div>

<form action="{{ route('hospitaldata.update', $hospital->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="col-md-12">
            <div class="form-group">
                <label>Hospital Name</label>
                <input type="text" class="form-control" name="name" value="{{ $hospital->name; }}">
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

  })
</script>
@endpush
