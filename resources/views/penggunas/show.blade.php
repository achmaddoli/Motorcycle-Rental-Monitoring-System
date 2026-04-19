@extends('penggunas.layout')

@section('content')
    <div class="row mb-4">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Detail Pengguna</h2>
            <a class="btn btn-primary" href="{{ route('penggunas.index') }}">← Kembali</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Nama:</h6>
                    <p class="fs-5">{{ $pengguna->nama }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">Alamat:</h6>
                    <p class="fs-5">{{ $pengguna->alamat }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">No HP:</h6>
                    <p class="fs-5">{{ $pengguna->no_hp }}</p>
                </div>
                <div class="col-md-6">
                    <h6 class="text-muted">ID Telegram:</h6>
                    <p class="fs-5">
                        @if ($pengguna->id_telegram)
                            {{ $pengguna->id_telegram }}
                        @else
                            <span class="badge bg-warning text-dark">Belum diisi</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <h6 class="text-muted">Foto Pelanggan:</h6>
                    @if ($pengguna->foto_pelanggan)
                        <img src="{{ asset('storage/penggunas/' . $pengguna->foto_pelanggan) }}" alt="Foto Pelanggan"
                            class="img-fluid rounded shadow-sm border" style="max-height: 300px;">
                    @else
                        <p class="text-muted fst-italic">Tidak ada foto tersedia.</p>
                    @endif
                </div>

                <div class="col-md-6">
                    <h6 class="text-muted">File KTP:</h6>
                    @if ($pengguna->file_ktp)
                        <a href="{{ asset('storage/penggunas/' . $pengguna->file_ktp) }}" target="_blank">
                            <img src="{{ asset('storage/penggunas/' . $pengguna->file_ktp) }}" alt="File KTP"
                                class="img-fluid rounded shadow-sm border" style="max-height: 300px;">
                        </a>
                    @else
                        <p class="text-muted fst-italic">Tidak ada file KTP tersedia.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
