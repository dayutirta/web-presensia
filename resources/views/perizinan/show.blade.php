@extends('layouts.user_type.auth')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Detail Perizinan</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Nama Pegawai</th>
                <td>{{ $perizinan->pegawai->nama_pegawai }}</td>
            </tr>
            <tr>
                <th>Jabatan</th>
                <td>{{ $perizinan->pegawai->jabatan }}</td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td>{{ $perizinan->tanggal_mulai }}</td>
            </tr>
            <tr>
                <th>Tanggal Selesai</th>
                <td>{{ $perizinan->tanggal_akhir }}</td>
            </tr>
            <tr>
                <th>Alasan</th>
                <td>{{ $perizinan->keterangan }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{{ $perizinan->status_izin }}</td>
            </tr>
        </table>
        <a href="{{ url('/perizinan') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@endsection
