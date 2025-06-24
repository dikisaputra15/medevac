@extends('layouts.master')

@section('title','Edit Airport')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Edit Airport</h3>
    </div>

<form action="{{ route('airportdata.update', $airport->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="col-md-12">
            <div class="form-group">
                <label>Airport Name</label>
                <input type="text" class="form-control" name="airport_name" value="{{ $airport->airport_name; }}">
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
