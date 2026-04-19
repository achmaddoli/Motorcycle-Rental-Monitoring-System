@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Tambah Data Sewa</h2>
            <a class="btn btn-primary" href="{{ route('sewas.index') }}">Kembali</a>
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

    {{-- Tambahkan card wrapper untuk ubah background --}}
    <div class="card shadow-sm mt-4" style="background-color: #f9fafb;"> {{-- bisa diganti #ffffff atau warna lain --}}
        <div class="card-body">
            <form action="{{ route('sewas.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>Nama Pengguna:</strong>
                            <select class="form-control" name="id_pengguna" required>
                                <option value="">Pilih Pengguna</option>
                                @foreach ($penggunas as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <div class="form-group">
                            <strong>Plat Kendaraan:</strong>
                            <select class="form-control" name="id_kendaraan" required>
                                <option value="">Pilih Kendaraan</option>
                                @foreach ($kendaraans as $k)
                                    <option value="{{ $k->id }}">{{ $k->nomor_kendaraan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <strong>Tanggal Mulai:</strong>
                            <input type="datetime-local" name="tanggal_mulai" class="form-control" id="tanggalMulai"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            <strong>Tanggal Selesai:</strong>
                            <input type="datetime-local" name="tanggal_selesai" class="form-control" id="tanggalSelesai"
                                required>
                        </div>
                    </div>

                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script tanggal tetap --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mulaiInput = document.getElementById('tanggalMulai');
            const selesaiInput = document.getElementById('tanggalSelesai');

            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const formattedNow = `${year}-${month}-${day}T${hours}:${minutes}`;

            mulaiInput.min = formattedNow;
            mulaiInput.value = formattedNow;

            mulaiInput.addEventListener('change', function() {
                selesaiInput.min = mulaiInput.value;
                if (selesaiInput.value < mulaiInput.value) {
                    selesaiInput.value = '';
                }
            });
        });
    </script>
@endsection
