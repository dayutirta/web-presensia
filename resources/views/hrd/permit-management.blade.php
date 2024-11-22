@extends('layouts.user_type.auth')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <h5 class="mb-0">Data Absensi</h5>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="table-responsive"> 
                <table class="table table-bordered table-striped table-hover table-sm" id="table_pegawai">
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
                </table>
            </div>
            
        </div>
    </div>
@endsection

@push('css')
    <style>
        @media (max-width: 575.98px) { 
            .col-form-label {
                text-align: left !important;
            }
        }
    </style>
@endpush

@push('js')
    <script>
        $(document).ready(function() {
            var table = $('#table_pegawai').DataTable({
                serverSide: true,
                ajax: {
                    url: "{{ url('pegawai/list') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: function(d) {
                        d.jabatan = $('#jabatan').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 2 },
                    { data: 'no_pegawai', name: 'no_pegawai',searchable: true, responsivePriority: 4 },
                    { data: 'nama_pegawai', name: 'nama_pegawai',searchable: true, responsivePriority: 1 }, 
                    { data: 'jabatan', name: 'jabatan',searchable: true, responsivePriority: 3 },
                    { data: 'nohp', name: 'nohp',searchable: true, responsivePriority: 5 },
                    { data: 'alamat', name: 'alamat',searchable: true, responsivePriority: 6 },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false, responsivePriority: 7 }
                ],
                "autoWidth": true,
                "responsive": true,
                "ordering":false,
            });

            $('#jabatan').on('change', function() {
                table.ajax.reload();
            });

            
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
