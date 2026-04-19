@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Edit Pengguna</h2>
            <a class="btn btn-primary" href="{{ route('penggunas.index') }}">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Bungkus form dengan card --}}
    <div class="card shadow-sm mt-4" style="background-color: #f9fafb;"> {{-- Ganti jadi #ffffff jika mau putih polos --}}
        <div class="card-body">
            <form action="{{ route('penggunas.update', $pengguna->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label><strong>Nama:</strong></label>
                    <input type="text" name="nama" value="{{ old('nama', $pengguna->nama) }}" class="form-control"
                        placeholder="Nama">
                </div>

                <div class="form-group">
                    <label><strong>Alamat:</strong></label>
                    <input type="text" name="alamat" value="{{ old('alamat', $pengguna->alamat) }}" class="form-control"
                        placeholder="Alamat">
                </div>

                <div class="form-group">
                    <label><strong>No HP:</strong></label>
                    <input type="text" name="no_hp" value="{{ old('no_hp', $pengguna->no_hp) }}" class="form-control"
                        placeholder="No HP">
                </div>

                <div class="form-group">
                    <label><strong>ID Telegram:</strong></label>
                    <input type="text" name="id_telegram" value="{{ old('id_telegram', $pengguna->id_telegram) }}"
                        class="form-control @error('id_telegram') is-invalid @enderror" placeholder="ID Telegram">

                    @error('id_telegram')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label><strong>Foto SIM:</strong></label><br>
                    @if ($pengguna->foto_pelanggan)
                        <a href="{{ asset('storage/penggunas/' . $pengguna->foto_pelanggan) }}" target="_blank">Lihat Foto
                            SIM</a><br>
                    @endif
                    <input type="file" name="foto_pelanggan" class="form-control-file">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto SIM.</small>
                </div>

                <div class="form-group mt-3">
                    <label><strong>File KTP:</strong></label><br>
                    @if ($pengguna->file_ktp)
                        <a href="{{ asset('storage/penggunas/' . $pengguna->file_ktp) }}" target="_blank">Lihat foto
                            KTP</a><br>
                    @endif
                    <input type="file" name="file_ktp" class="form-control-file">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto KTP.</small>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
