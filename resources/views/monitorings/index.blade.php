@extends('layouts.main')

@section('content')
    <style>
        #monitoring-table,
        #monitoring-table th,
        #monitoring-table td {
            border: 1px solid #0c0c0c;
            border-collapse: collapse;
        }
    </style>
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Data Monitoring Kendaraan</h2>
            <a hidden class="btn btn-success" href="{{ route('monitorings.create') }}">Tambah Monitoring</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="monitoring-table" style="width: 100%">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Kendaraan</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Status Geofencing</th>
                    <th>Sisa Waktu</th>
                    <th width="180px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript">
        // ✅ Tambahkan setup CSRF agar form Delete aman
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $('#monitoring-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('monitorings.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pengguna',
                        name: 'pengguna'
                    },
                    {
                        data: 'kendaraan',
                        name: 'kendaraan'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude'
                    },
                    {
                        data: 'is_inside',
                        name: 'is_inside',
                        render: function(data, type, row) {
                            return data == 1 ? 'di Dalam Palembang' : 'di Luar Palembang';
                        }
                    },
                    {
                        data: 'sisa_waktu',
                        name: 'sisa_waktu'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush
