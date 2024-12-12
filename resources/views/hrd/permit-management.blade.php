@extends('layouts.user_type.auth')

@section('content')
<div class="card card-outline card-primary">
    {{-- <div class="card-header">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <h5 class="mb-0">Data Perizinan</h5>
            <a href="{{ url('/perizinan/create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Perizinan
            </a>
        </div>
    </div> --}}
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
                        <th>Jabatan</th>
                        <th>Tanggal Izin</th>
                        <th>Alasan</th>
                        <th>Status</th>
                        <th>Ubah Status</th>
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
                { data: 'pegawai.jabatan', name: 'pegawai.jabatan', responsivePriority: 3 },
                { data: 'tanggal_mulai', name: 'tanggal_mulai', responsivePriority: 4 },
                { data: 'keterangan', name: 'keterangan', responsivePriority: 5 },
                { data: 'status_izin', name: 'status_izin'},
                {
                    data: 'ubah_status',
                    name: 'ubah_status',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        let buttons = '';

                        if (row.status_izin === 'Pending') {
                            buttons = `
                                <form action="/perizinan/${row.id_izin}/accept" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success btn-sm">Terima</button>
                                </form>
                                <form action="/perizinan/${row.id_izin}/reject" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Tolak</button>
                                </form>
                            `;
                        } else {
                            buttons = `<span class="badge bg-secondary">${row.status_izin}</span>`;
                        }

                        return buttons;
                    }
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        let buttons = `
                            <div class="btn-group">
                                <a href="/perizinan/${row.id_izin}" class="btn btn-outline-primary btn-sm">Lihat</a>
                                <button data-id="${row.id_izin}" class="btn btn-outline-danger btn-sm btn-delete">Hapus</button>
                            </div>
                        `;
                        return buttons;
                    }
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

        $(document).on('click', '.btn-delete', function () {
            var id = $(this).data('id');
            if (confirm('Yakin ingin menghapus data ini?')) {
                $.ajax({
                    url: `/perizinan/${id}`,
                    type: 'POST',
                    data: {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        alert(response.message);
                        $('#table_perizinan').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseText);
                    }
                });
            }
        });

    });
</script>
@endpush
