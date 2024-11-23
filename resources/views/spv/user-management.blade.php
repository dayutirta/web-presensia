@extends('layouts.user_type.auth')

@section('content')
<div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">All Users</h5>
                        </div>
                        <a href="#" class="btn bg-gradient-primary btn-sm mb-0" type="button">+ New User</a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <div class="table-responsive p-0">
                        <table id="table_pegawai" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Nomor</th>
                                    <th>Nomor Pegawai</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>No Telepon</th>
                                    <th>Alamat</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be dynamically populated by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#table_pegawai').DataTable({
                serverSide: true,
                ajax: {
                    "url": "{{ url('pegawai/list') }}",
                    "type": "POST",
                    "headers": {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'no_pegawai', name: 'no_pegawai', orderable: false, searchable: true },
                    { data: 'nama_pegawai', name: 'nama_pegawai', orderable: false, searchable: true },
                    { data: 'jabatan', name: 'jabatan', orderable: false, searchable: true },
                    { data: 'nohp', name: 'nohp', orderable: false, searchable: true },
                    { data: 'alamat', name: 'alamat', orderable: false, searchable: true },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false }
                ],
                "autoWidth": false,
                "responsive": true,
                "ordering": false
            });

            // $('#nokk').on('change', function() {
            //     table.ajax.reload();
            // });

            var resizeTimer;
            $(window).on('resize', function(e) {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    table.ajax.reload(null, false); 
                }, 1); 
            });
        });
    </script>
@endpush
@endsection
