@extends('layouts.main')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Data Sewa</h2>
            <a class="btn btn-success" href="{{ route('sewas.create') }}">Tambah Data Sewa</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="sewas-table" style="width: 100%;">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Nomor HP</th>
                    <th>Plat Kendaraan</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Durasi Penyewaan (Hari)</th>
                    <th width="180px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $('#sewas-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('sewas.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'nama_pengguna',
                        name: 'nama_pengguna'
                    },
                    {
                        data: 'nomor_hp',
                        name: 'nomor_hp'
                    },
                    {
                        data: 'plat_kendaraan',
                        name: 'plat_kendaraan'
                    },
                    {
                        data: 'tanggal_mulai',
                        name: 'tanggal_mulai'
                    },
                    {
                        data: 'tanggal_selesai',
                        name: 'tanggal_selesai'
                    },
                    {
                        data: 'durasi_penyewaan',
                        name: 'durasi_penyewaan',
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
