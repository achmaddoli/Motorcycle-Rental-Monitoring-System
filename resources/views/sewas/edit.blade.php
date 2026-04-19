@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Edit Data Sewa</h2>
            <a class="btn btn-primary" href="{{ route('sewas.index') }}">Kembali</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> Ada kesalahan dalam input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Tambahkan card pembungkus --}}
    <div class="card shadow-sm mt-4" style="background-color: #f9fafb;">
        <div class="card-body">
            <form action="{{ route('sewas.update', $sewa->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Pengguna -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="id_pengguna"><strong>Pengguna</strong></label>
                            <select name="id_pengguna" class="form-control" required>
                                @foreach ($penggunas as $pengguna)
                                    <option value="{{ $pengguna->id }}"
                                        {{ old('id_pengguna', $sewa->id_pengguna) == $pengguna->id ? 'selected' : '' }}>
                                        {{ $pengguna->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Kendaraan -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="id_kendaraan"><strong>Kendaraan</strong></label>
                            <select name="id_kendaraan" class="form-control" required>
                                @foreach ($kendaraans as $kendaraan)
                                    <option value="{{ $kendaraan->id }}"
                                        {{ old('id_kendaraan', $sewa->id_kendaraan) == $kendaraan->id ? 'selected' : '' }}>
                                        {{ $kendaraan->nomor_kendaraan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="tanggal_mulai"><strong>Tanggal Mulai</strong></label>
                            <input type="datetime-local" id="tanggalMulaiDisabled" class="form-control"
                                value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('Y-m-d\TH:i')) }}"
                                disabled>
                            <input type="hidden" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai', \Carbon\Carbon::parse($sewa->tanggal_mulai)->format('Y-m-d\TH:i')) }}">
                        </div>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="tanggal_selesai"><strong>Tanggal Selesai</strong></label>
                            <input type="datetime-local" id="tanggalSelesai" name="tanggal_selesai" class="form-control"
                                value="{{ old('tanggal_selesai', \Carbon\Carbon::parse($sewa->tanggal_selesai)->format('Y-m-d\TH:i')) }}"
                                min="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>

                    <!-- Durasi Penyewaan -->
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            <label for="durasi_penyewaan"><strong>Durasi Penyewaan (hari)</strong></label>
                            <input type="number" name="durasi_penyewaan" class="form-control"
                                value="{{ old('durasi_penyewaan', $sewa->durasi_penyewaan) }}" readonly>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12 text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Script tetap di luar form --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mulaiInput = document.querySelector('input[name="tanggal_mulai"]');
            const selesaiInput = document.getElementById('tanggalSelesai');
            const durasiInput = document.querySelector('input[name="durasi_penyewaan"]');

            const now = new Date().toISOString().slice(0, 16);
            const minDate = mulaiInput.value > now ? mulaiInput.value : now;
            selesaiInput.min = minDate;

            selesaiInput.addEventListener('change', function() {
                const startDate = new Date(mulaiInput.value);
                const endDate = new Date(selesaiInput.value);
                const duration = Math.floor((endDate - startDate) / (1000 * 3600 * 24));

                if (duration >= 0) {
                    durasiInput.value = duration;
                } else {
                    alert("Tanggal selesai harus lebih besar dari tanggal mulai.");
                    selesaiInput.value = '';
                    durasiInput.value = '';
                }
            });
        });
    </script>
@endsection
