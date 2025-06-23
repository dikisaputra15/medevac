@extends('layouts.master')

@section('title','Embessy')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Embessy List</h3>
    </div>

     <div id="session" data-session="{{ session('success') }}"></div>

    <div class="card-body">
            <table id="embessyTable" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Embassy Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>

            </table>
    </div>
</div>
@endsection

@push('service')
  <script>
        $(document).ready(function() {

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

            // table data
            $('#embessyTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "/embessydata",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name_embassiees',
                        name: 'name_embassiees'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });


        });
    </script>
@endpush
