@extends('layouts.main')

@section('content')

<style>
        #map {
            z-index: 1;
        }
    </style>


    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Detail Monitoring</h2>
            <a class="btn btn-primary" href="{{ route('monitorings.index') }}">Kembali</a>
        </div>
    </div>

    {{-- Bungkus konten dalam card --}}
    <div class="card shadow-sm mt-4" style="background-color: #f9fafb;">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <strong>ID Kendaraan:</strong>
                        <input type="text" class="form-control" value="{{ $monitoring->id_kendaraan }}" readonly>
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <strong>Longitude:</strong>
                        <input type="text" id="longitude" class="form-control" value="{{ $monitoring->longitude }}"
                            readonly>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <div class="form-group">
                        <strong>Latitude:</strong>
                        <input type="text" id="latitude" class="form-control" value="{{ $monitoring->latitude }}"
                            readonly>
                    </div>
                </div>

                <div class="col-md-12 mb-4">
                    <strong>Lokasi pada Peta:</strong>
                    <div id="map" style="height: 400px; width: 100%; border-radius: 10px;"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    {{-- jQuery CDN --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    {{-- Realtime Leaflet Script --}}
    <script>
        let map, marker;

        $(document).ready(function() {
            const initialLat = parseFloat($('#latitude').val());
            const initialLon = parseFloat($('#longitude').val());

            map = L.map('map').setView([initialLat, initialLon], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors'
            }).addTo(map);

            const motorIcon = L.icon({
                iconUrl: '/logo/motorcycle.png',
                iconSize: [30, 30],
                iconAnchor: [15, 30],
                popupAnchor: [0, -30]
            });

            marker = L.marker([initialLat, initialLon], {
                    icon: motorIcon
                }).addTo(map)
                .bindPopup("<b>Lokasi Kendaraan</b><br>Latitude: " + initialLat + "<br>Longitude: " + initialLon)
                .openPopup();

            setInterval(fetchLocation, 2000);
        });

        function fetchLocation() {
            $.ajax({
                url: "{{ url('/api/monitoring/' . $monitoring->id_kendaraan) }}",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status) {
                        const newLat = parseFloat(response.latitude);
                        const newLon = parseFloat(response.longitude);

                        $('#latitude').val(newLat);
                        $('#longitude').val(newLon);

                        marker.setLatLng([newLat, newLon]);
                        marker.setPopupContent("<b>Lokasi Kendaraan</b><br>Latitude: " + newLat +
                            "<br>Longitude: " + newLon);
                        map.panTo([newLat, newLon]);
                    } else {
                        console.warn("Data tidak ditemukan.");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Gagal memperbarui lokasi:", error);
                }
            });
        }
    </script>
@endsection
