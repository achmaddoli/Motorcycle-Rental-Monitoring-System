<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Monitoring Motor</title>
    <!-- base:css -->
    <link rel="stylesheet" href="/celestial/vendors/typicons.font/font/typicons.css">
    <link rel="stylesheet" href="/celestial/vendors/css/vendor.bundle.base.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Geocoder Plugin -->
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
     <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>


    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="/celestial/css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="/logo/logomotor.png" />
    <link href="https://cdn.datatables.net/1.12.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <style>
        .dataTables_paginate,
        .dataTables_info {
            margin-top: 20px;
        }

        .dataTable,
        .dataTable th,
        .dataTable td {
            border: 1px solid #000000;
            border-collapse: collapse;
        }

        /* Opsional: border lebih tegas */
        .dataTable th,
        .dataTable td {
            text-align: center;
        }

        .dataTables_filter {
            float: right !important;
        }
    </style>
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_navbar.html -->
        @include('layouts.topbar')
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->

            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            @include('layouts.sidebar')
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>


    <!-- container-scroller -->
    <!-- base:js -->
    <script src="/celestial/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="/celestial/js/off-canvas.js"></script>
    <script src="/celestial/js/hoverable-collapse.js"></script>
    <script src="/celestial/js/template.js"></script>
    <script src="/celestial/js/settings.js"></script>
    <script src="/celestial/js/todolist.js"></script>
    <!-- endinject -->
    <!-- plugin js for this page -->
    <script src="/celestial/vendors/progressbar.js/progressbar.min.js"></script>
    <script src="/celestial/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- Custom js for this page-->
    <script src="/celestial/js/dashboard.js"></script>
    <!-- End custom js for this page-->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    @stack('scripts')

    <style>
        /* Matikan tooltip default Bootstrap */
        .tooltip {
            display: none !important;
        }
    </style>

    <script>
        // Nonaktifkan semua tooltip jika ada inisialisasi otomatis
        $(function() {
            $('[data-toggle="tooltip"]').tooltip('dispose');
        });
    </script>

</body>

</html>
