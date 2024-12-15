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
            <table class="table table-bordered table-striped table-hover table-sm" id="table_absensi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>Tanggal</th>
                        <th>Jam Kerja</th>
                        <th>Status Absen</th>
                        <th>Lokasi Absen</th>
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
    var table = $('#table_absensi').DataTable({
        serverSide: true,
        ajax: {
            url: "{{ url('/absensi/list') }}",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, responsivePriority: 1 },
            { data: 'pegawai.nama_pegawai', name: 'pegawai.nama_pegawai', responsivePriority: 2 },
            { data: 'tanggal', name: 'tanggal', responsivePriority: 3 },
            {
                data: null,
                name: 'waktu_keluar',
                responsivePriority: 5,
                render: function(data, type, row) {
                    const waktuMasuk = row.waktu_masuk ? row.waktu_masuk.split(' ')[1] : '--:--:--';
                    const waktuKeluar = row.waktu_keluar ? row.waktu_keluar.split(' ')[1] : '--:--:--';
                    return `${waktuMasuk} / ${waktuKeluar}`;
                }
            },
            { data: 'status_absen', name: 'status_absen', responsivePriority: 6 },
            { data: 'lokasi_absen', name: 'lokasi_absen', responsivePriority: 7 },
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Laporan Absensi',
                text: '<i class="fas fa-file-excel"></i> Excel',
            },
            {
                extend: 'print',
                title: 'Laporan Absensi',
                text: '<i class="fas fa-print"></i> Print',
            }
        ],
        paging: false, 
        stateSave: true,
        autoWidth: true,
        responsive: true,
        ordering: false
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
