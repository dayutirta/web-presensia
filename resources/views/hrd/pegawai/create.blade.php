@extends('layouts.user_type.auth')

@section('content')
<div class="card card-outline card-info">
    <div class="card-header">
        <h5 class="mb-0">Tambah Data Pegawai</h5>
    </div>
    <div class="card-body">
        <!-- Menampilkan pesan sukses atau error jika ada -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/pegawai') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="id_level" class="form-label">Jabatan</label>
                <select name="id_level" id="id_level" class="form-control" required>
                    <option value="">Pilih Jabatan</option> <!-- Menambahkan pilihan kosong untuk validasi -->
                    @foreach ($level as $lvl)
                        <option value="{{ $lvl->id_level }}" {{ old('id_level') == $lvl->id_level ? 'selected' : '' }}>
                            {{ $lvl->nama_level }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label for="nama_pegawai" class="form-label">Nama Pegawai</label>
                <input type="text" name="nama_pegawai" id="nama_pegawai" class="form-control" value="{{ old('nama_pegawai') }}" required>
            </div>
            <div class="mb-3">
                <label for="no_pegawai" class="form-label">Nomor Pegawai</label>
                <input type="text" name="no_pegawai" id="no_pegawai" class="form-control" value="{{ old('no_pegawai') }}" required>
            </div>
            <div class="mb-3">
                <label for="jabatan" class="form-label">Bagian</label>
                <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan') }}" required>
                <input type="number" name="id_level" id="id_level" class="form-control" value="3" hidden>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="nohp" class="form-label">Nomor Telepon</label>
                <input type="text" name="nohp" id="nohp" class="form-control" value="{{ old('nohp') }}" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" value="{{ old('password') }}" required>
            </div>
            <button type="submit" class="btn bg-gradient-info">Simpan</button>
            <a href="{{ url('/pegawai') }}" class="btn bg-gradient-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
