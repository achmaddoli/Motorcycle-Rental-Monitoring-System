@extends('penggunas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Edit Pengaturan Geofence</h2>
            <a class="btn btn-secondary" href="{{ route('pengaturans.index') }}">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> Ada masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengaturans.update', $pengaturan->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="longitude"><strong>Longitude:</strong></label>
                    <input type="number" step="any" name="longitude" id="longitude"
                        value="{{ $pengaturan->longitude }}" class="form-control" placeholder="Contoh: 104.676195" required>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="latitude"><strong>Latitude:</strong></label>
                    <input type="number" step="any" name="latitude" id="latitude" value="{{ $pengaturan->latitude }}"
                        class="form-control" placeholder="Contoh: -2.913546" required>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <label for="radius"><strong>Radius (dalam meter):</strong></label>
                    <input type="number" name="radius" id="radius" value="{{ $pengaturan->radius }}"
                        class="form-control" placeholder="Contoh: 1000" required>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label for="keterangan"><strong>Keterangan Lokasi:</strong></label>
                    <input type="text" name="keterangan" id="keterangan" value="{{ $pengaturan->keterangan }}"
                        class="form-control" placeholder="Contoh: Area Geofence Palembang" required>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success px-4">Simpan</button>
            </div>
        </div>
    </form>
@endsection
