@extends('layouts.user_type.auth')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h5 class="mb-0">Data Perizinan</h5>
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
            <table class="table table-bordered table-striped table-hover table-sm" id="table_perizinan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Jenis Izin</th>
                        <th>Tanggal Izin</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Dokumen</th>
                        <th>Status</th>
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
        var table = $('#table_perizinan').DataTable({
            serverSide: true,
            ajax: {
                url: "{{ url('/perizinan/list') }}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [
    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 1 },
    { data: 'pegawai.nama_pegawai', name: 'pegawai.nama_pegawai', responsivePriority: 2 },
    { data: 'jenis_izin', name: 'jenis_izin', responsivePriority: 7 },
    {
        data: null, 
        name: 'tanggal_range',
        render: function(data, type, row) {
            let tanggalMulai = row.tanggal_mulai ? row.tanggal_mulai : '-';
            let tanggalAkhir = row.tanggal_akhir ? row.tanggal_akhir : '-';
            return `${tanggalMulai} - ${tanggalAkhir}`;
        },
        responsivePriority: 4
    },
    { data: 'keterangan', name: 'keterangan', responsivePriority: 3 },
    { data: 'status_izin', name: 'status_izin', visible: false },
    { 
        data: 'dokumen', 
        name: 'dokumen', 
        responsivePriority: 5,
        orderable: false,
        searchable: false
    },
    {
        data: 'ubah_status',
        name: 'ubah_status',
        orderable: false,
        searchable: false,
        responsivePriority: 6
    },
    {
        data: 'aksi',
        name: 'aksi',
        orderable: false,
        searchable: false,
        visible: false
    }
],


            autoWidth: true,
            responsive: true,
            ordering: false,
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
