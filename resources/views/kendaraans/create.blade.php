@extends('layouts.main')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Tambah Kendaraan Baru</h2>
            <a class="btn btn-outline-primary" href="{{ route('kendaraans.index') }}">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Terdapat beberapa kesalahan dalam input Anda:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('kendaraans.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="exampleSelectType">Tipe Kendaraan</label>
                    <select name="tipe_kendaraan" class="form-control" id="exampleSelectType">
                        <option selected disabled>Pilih Tipe Kendaraan</option>
                        <option value="Matic">Matic</option>
                        <option value="Manual">Manual</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="exampleInputNomorKendaraan">Nomor Kendaraan</label>
                    <input type="text" name="nomor_kendaraan"
                        class="form-control @error('nomor_kendaraan') is-invalid @enderror" id="exampleInputNomorKendaraan"
                        placeholder="BG XXXX" value="{{ old('nomor_kendaraan') }}">

                    @error('nomor_kendaraan')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="pilihan">Status Kendaraan</label>
                    <select name="status_kendaraan" class="form-control" id="pilihan">
                        <option selected disabled>Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Non Aktif</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="foto" class="form-label"><strong>Foto Kendaraan</strong></label>
                    <input type="file" name="foto" class="form-control" id="foto">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
