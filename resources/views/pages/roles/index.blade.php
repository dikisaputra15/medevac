@extends('layouts.master')

@section('title','Role')

@section('conten')

<div class="card">
    <div class="card-header bg-white">
        <h3>Role List</h3>
    </div>

     <div id="session" data-session="{{ session('success') }}"></div>

    <div class="card-body">
         <div class="mb-3 d-flex justify-content-start">
            <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm ml-2">Tambah data</a>
        </div>
            <table id="userTable" class="table" style="width:100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Role</th>
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
            $('#userTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
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
            $('#userTable').on('click', '.delete-btn', function () {
                var roleId = $(this).data('id');

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data akan dihapus secara permanen!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/roles/' + roleId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response){
                            if(response.success == 1){
                                alert("Record deleted.");
                                var oTable = $('#userTable').dataTable();
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
