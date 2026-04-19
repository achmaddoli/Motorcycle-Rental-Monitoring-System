@extends('layouts.main')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Add New Pengguna</h2>
            <a class="btn btn-primary" href="{{ route('penggunas.index') }}">Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tambahkan wrapper dengan background netral --}}
    <div class="card shadow-sm" style="background-color: #f9fafb;"> {{-- Bisa diganti ke #ffffff untuk putih total --}}
        <div class="card-body">
            <form action="{{ route('penggunas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>Nama:</strong>
                            <input type="text" name="nama" class="form-control" placeholder="Nama">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>Alamat:</strong>
                            <input type="text" name="alamat" class="form-control" placeholder="Alamat">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>No HP:</strong>
                            <input type="text" name="no_hp" class="form-control" placeholder="No HP">
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>ID Telegram:</strong>
                            <input type="text" name="id_telegram"
                                class="form-control @error('id_telegram') is-invalid @enderror" placeholder="ID Telegram"
                                value="{{ old('id_telegram') }}">

                            @error('id_telegram')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>Foto SIM:</strong>
                            <input type="file" name="foto_pelanggan" class="form-control" placeholder="Foto SIM">
                        </div>
                    </div>

                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <strong>Foto KTP:</strong>
                            <input type="file" name="file_ktp" class="form-control" placeholder="Foto KTP">
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
