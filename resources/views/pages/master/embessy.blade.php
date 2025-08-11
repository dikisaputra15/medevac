@extends('layouts.master')

@section('title','Embessy')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Embessy List</h3>
    </div>

     <div id="session" data-session="{{ session('success') }}"></div>

    <div class="card-body">
         <div class="form-group">
            <a href="{{route('embessydata.create')}}" class="btn btn-primary">Add Data</a>
        </div>
            <table id="embessyTable" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Embassy Name</th>
                      <th>Created At</th>
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
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

               // Event listener untuk tombol hapus
            $('#embessyTable').on('click', '.delete-btn', function () {
                var roleId = $(this).data('id');

                Swal.fire({
                    title: "Are you sure?",
                    text: "Data will be deleted permanently!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, Delete!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/embessydata/' + roleId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response){
                            if(response.success == 1){
                                alert("Record deleted.");
                                var oTable = $('#embessyTable').dataTable();
                                oTable.fnDraw(false);
                            }else{
                                    alert("Invalid ID.");
                                }
                            },

                        });
                    }
                });
            });


        });
    </script>
@endpush
