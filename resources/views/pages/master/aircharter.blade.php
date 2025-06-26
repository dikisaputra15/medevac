@extends('layouts.master')

@section('title','Aircharter')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Aircharter Update</h3>
    </div>

    <div id="session" data-session="{{ session('success') }}"></div>

<form action="{{ route('aircharterdata.update', $airport->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="col-md-12">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">
                Edit Aircharter Information
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

                <textarea id="summernote" name="charter_info">
                    <?php echo $airport->charter_info; ?>
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

        let session = $('#session').data('session');

            if (session) {
                Swal.fire({
                    title: "Sukses!",
                    text: session,
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: true
                });
            }

        // Summernote
        $('#summernote').summernote()

    })
</script>
@endpush
