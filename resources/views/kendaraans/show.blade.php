@extends('layouts.main')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Detail Kendaraan</h2>
            <a class="btn btn-primary" href="{{ route('kendaraans.index') }}">← Kembali</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="mb-2 text-muted">Tipe Kendaraan:</h5>
                    <p class="fs-5">{{ $kendaraan->tipe_kendaraan }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-2 text-muted">Nomor Kendaraan:</h5>
                    <p class="fs-5">{{ $kendaraan->nomor_kendaraan }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h5 class="mb-2 text-muted">Status Kendaraan:</h5>
                    <p class="fs-5">{{ ucfirst($kendaraan->status_kendaraan) }}</p>
                </div>
                <div class="col-md-6">
                    <h5 class="mb-2 text-muted">Foto Kendaraan:</h5>
                    @if ($kendaraan->foto)
                        <img src="{{ asset('storage/foto_kendaraan/' . $kendaraan->foto) }}"
                            class="img-fluid rounded shadow-sm border" alt="Foto Kendaraan" style="max-height: 300px;">
                    @else
                        <p class="text-muted fst-italic">Tidak ada foto tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
