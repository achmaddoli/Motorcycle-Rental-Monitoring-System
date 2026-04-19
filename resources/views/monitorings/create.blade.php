@extends('monitorings.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Tambah Monitoring Kendaraan</h2>
            <a class="btn btn-primary" href="{{ route('monitorings.index') }}">Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> Ada beberapa masalah dengan inputmu.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('monitorings.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="id_pengguna"><strong>Pengguna:</strong></label>
                    <select name="id_pengguna" class="form-control">
                        <option value="">Pilih Pengguna</option>
                        @foreach ($penggunas as $pengguna)
                            <option value="{{ $pengguna->id }}">{{ $pengguna->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="id_kendaraan"><strong>Kendaraan:</strong></label>
                    <select name="id_kendaraan" class="form-control">
                        <option value="">Pilih Kendaraan</option>
                        @foreach ($kendaraans as $kendaraan)
                            <option value="{{ $kendaraan->id }}">{{ $kendaraan->nomor_kendaraan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="longitude"><strong>Longitude:</strong></label>
                    <input type="text" name="longitude" class="form-control" placeholder="Longitude">
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="latitude"><strong>Latitude:</strong></label>
                    <input type="text" name="latitude" class="form-control" placeholder="Latitude">
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
@endsection
