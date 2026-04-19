@extends('layouts.main')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Edit Kendaraan</h2>
            <a class="btn btn-primary" href="{{ route('kendaraans.index') }}">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tambahan wrapper card --}}
    <div class="card shadow-sm" style="background-color: #f9fafb;"> {{-- Ganti #ffffff jika ingin putih polos --}}
        <div class="card-body">
            <form action="{{ route('kendaraans.update', $kendaraan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="col-md-12 mb-3">
                    <label for="exampleSelectType"><strong>Tipe Kendaraan</strong></label>
                    <select name="tipe_kendaraan" class="form-control" id="exampleSelectType" required>
                        <option disabled {{ $kendaraan->tipe_kendaraan == null ? 'selected' : '' }}>Pilih Tipe Kendaraan
                        </option>
                        <option value="Matic" {{ $kendaraan->tipe_kendaraan == 'Matic' ? 'selected' : '' }}>Matic</option>
                        <option value="Manual" {{ $kendaraan->tipe_kendaraan == 'Manual' ? 'selected' : '' }}>Manual
                        </option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label><strong>Nomor Kendaraan:</strong></label>
                    <input type="text" name="nomor_kendaraan"
                        value="{{ old('nomor_kendaraan', $kendaraan->nomor_kendaraan) }}" class="form-control"
                        placeholder="Nomor Kendaraan">
                </div>

                <div class="col-md-12 mb-3">
                    <label><strong>Status Kendaraan:</strong></label>
                    <select name="status_kendaraan" class="form-control">
                        <option value="aktif" {{ $kendaraan->status_kendaraan == 'aktif' ? 'selected' : '' }}>Aktif
                        </option>
                        <option value="tidak aktif" {{ $kendaraan->status_kendaraan == 'tidak aktif' ? 'selected' : '' }}>
                            Tidak Aktif</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label><strong>Foto Kendaraan:</strong></label><br>
                    @if ($kendaraan->foto)
                        <a href="{{ asset('storage/kendaraans/' . $kendaraan->foto) }}" target="_blank">Lihat Foto
                            Kendaraan</a><br>
                    @endif
                    <input type="file" name="foto" class="form-control-file mt-2">
                    <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti foto kendaraan.</small>
                </div>

                <div class="col-md-12 text-center mt-4">
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
