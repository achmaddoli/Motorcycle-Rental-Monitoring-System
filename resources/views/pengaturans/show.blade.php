@extends('monitorings.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Detail Pengaturan</h2>
            <a class="btn btn-primary" href="{{ route('pengaturans.index') }}">Back</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Longitude:</strong>
                <input type="text" class="form-control" value="{{ $pengaturan->longitude }}" readonly>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Latitude:</strong>
                <input type="text" class="form-control" value="{{ $pengaturan->latitude }}" readonly>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Radius (meter):</strong>
                <input type="text" class="form-control" value="{{ $pengaturan->radius }}" readonly>
            </div>
        </div>

        <div class="col-md-12 mb-3">
            <div class="form-group">
                <strong>Keterangan:</strong>
                <textarea class="form-control" rows="3" readonly>{{ $pengaturan->keterangan }}</textarea>
            </div>
        </div>

        <div class="col-md-12 mb-4">
            <strong>Lokasi pada Peta:</strong>
            <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
        </div>
    </div>

    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- Leaflet Map Script --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lat = {{ $pengaturan->latitude }};
            var lon = {{ $pengaturan->longitude }};
            var radius = {{ $pengaturan->radius }};

            var map = L.map('map').setView([lat, lon], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tambahkan marker
            L.marker([lat, lon]).addTo(map)
                .bindPopup("<b>Lokasi</b><br>Latitude: " + lat + "<br>Longitude: " + lon)
                .openPopup();

            // Tambahkan lingkaran radius
            L.circle([lat, lon], {
                color: 'blue',
                fillColor: '#blue',
                fillOpacity: 0.2,
                radius: radius
            }).addTo(map);
        });
    </script>
@endsection
