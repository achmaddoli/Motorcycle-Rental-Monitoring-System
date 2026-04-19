@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Add New Pengaturan</h2>
            <a class="btn btn-primary" href="{{ route('pengaturans.index') }}">Back</a>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengaturans.store') }}" method="POST" class="mt-4">
        @csrf

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>Longitude:</strong>
                    <input type="text" name="longitude" class="form-control" placeholder="Longitude" required>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>Latitude:</strong>
                    <input type="text" name="latitude" class="form-control" placeholder="Latitude" required>
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>Radius:</strong>
                    <input type="text" name="radius" class="form-control" placeholder="Radius" required>
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="form-group">
                    <strong>Keterangan:</strong>
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan" required>
                </div>
            </div>

            <!-- Map section -->
            <div class="col-md-12 mb-4">
                <div class="form-group">
                    <strong>Pilih Lokasi di Peta / Cari Lokasi:</strong>
                    <div id="map" style="height: 400px;"></div>
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
    <script>
        var map = L.map('map').setView([-0.5021, 117.1537], 13); // Default Samarinda

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        var marker;

        // Handle click on map
        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lng]).addTo(map);

            document.querySelector("input[name='latitude']").value = lat;
            document.querySelector("input[name='longitude']").value = lng;
        });

        // Add search control
        L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                var latlng = e.geocode.center;

                if (marker) {
                    map.removeLayer(marker);
                }

                marker = L.marker(latlng).addTo(map);
                map.setView(latlng, 16);

                document.querySelector("input[name='latitude']").value = latlng.lat;
                document.querySelector("input[name='longitude']").value = latlng.lng;
            })
            .addTo(map);
    </script>
@endsection
