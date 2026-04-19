@extends('layouts.main')

@section('content')
    <style>
        #map {
            z-index: 1;
        }
    </style>

    <div class="content-wrapper px-3">
        <div class="row mb-4">
            <div class="col-12">
                <div class="bg-white p-4 rounded shadow-sm d-flex justify-content-between align-items-center">
                    <h2 class="text-dark fw-bold mb-0">👋 Welcome Back, {{ Auth::user()->name }}</h2>
                </div>
            </div>
        </div>

        <div class="row fade-in">
            <div class="col-lg-12">
                <div class="card border-0 shadow rounded-4 overflow-hidden">
                    <div class="card-header bg-white text-black rounded-top-4 d-flex align-items-center">
                        <h5 class="card-title mb-0 fw-semibold">
                            <span class="me-2">📍</span> Peta Polygon Geofencing - Kota Palembang
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="map"
                            style="height: 500px; border-bottom-left-radius: 1rem; border-bottom-right-radius: 1rem;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet & CSV Parser -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/papaparse@5.3.2/papaparse.min.js"></script>

    <!-- Styling Enhancement -->
    <style>
        body {
            background-color: #f1f4f9;
        }

        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(15px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #ffffff;
        }

        .card {
            background-color: #ffffff;
            transition: all 0.3s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12);
        }

        .bg-dark {
            background-color: #2c3e50 !important;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        .fw-bold {
            font-weight: 700 !important;
        }

        .fw-semibold {
            font-weight: 600 !important;
        }

        #map {
            width: 100%;
        }
    </style>

    <!-- JS Logic (tidak diubah) -->
    <script>
        var data_motor = @json($data);
        console.log(data_motor);

        document.addEventListener('DOMContentLoaded', function() {
            const map = L.map('map').setView([-2.9761, 104.7453], 11);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            fetch("/titik_batas_palembang.csv")
                .then(response => response.text())
                .then(csvText => {
                    Papa.parse(csvText, {
                        header: true,
                        skipEmptyLines: true,
                        complete: function(results) {
                            const data = results.data;

                            const coordinates = data
                                .map(row => {
                                    const latRaw = row.latitude ?? row.Latitude;
                                    const lonRaw = row.longitude ?? row.Longitude;

                                    if (!latRaw || !lonRaw) return null;

                                    const lat = parseFloat(latRaw.toString().trim());
                                    const lon = parseFloat(lonRaw.toString().trim());

                                    if (!isNaN(lat) && !isNaN(lon)) {
                                        return [lat, lon];
                                    }
                                    return null;
                                })
                                .filter(coord => Array.isArray(coord));

                            // ✅ Tambahkan titik awal sebagai titik akhir untuk menutup polygon
                            if (coordinates.length > 0 &&
                                (coordinates[0][0] !== coordinates.at(-1)[0] || coordinates[0][
                                    1
                                ] !== coordinates.at(-1)[1])) {
                                coordinates.push(coordinates[0]);
                            }

                            if (coordinates.length === 0) {
                                console.error("Tidak ada koordinat valid ditemukan di CSV.");
                                return;
                            }

                            const polygon = L.polygon(coordinates, {
                                color: 'blue',
                                fillOpacity: 0.4
                            }).addTo(map);

                            polygon.bindPopup("Area Geofencing: Kota Palembang");
                        }
                    });
                })
                .catch(error => {
                    console.error("Gagal mengambil CSV:", error);
                });

            data_motor.forEach(item => {
                if (item.latitude && item.longitude) {
                    const lat = parseFloat(item.latitude);
                    const lon = parseFloat(item.longitude);

                    if (!isNaN(lat) && !isNaN(lon)) {
                        const motorIcon = L.icon({
                            iconUrl: '/logo/motorcycle.png', // pastikan file ini ada di public/images/motor.png
                            iconSize: [30, 30], // ukuran ikon motor
                            iconAnchor: [20, 40], // posisi anchor (tengah bawah)
                            popupAnchor: [0, -40] // posisi popup relatif ke ikon
                        });

                        const marker = L.marker([lat, lon], {
                            icon: motorIcon
                        }).addTo(map);
                        marker.bindPopup(
                            ` <strong>Pengguna:</strong> ${item.nama_pengguna}<br>
                            <strong>Plat Kendaraan:</strong> ${item.plat_nomor}<br>
                            <strong>Waktu Selesai:</strong> ${item.tanggal_selesai}`
                        );
                    }
                }
            });
        });
    </script>
@endpush
