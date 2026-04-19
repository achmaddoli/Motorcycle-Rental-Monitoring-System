@extends('layouts.main')

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2>Data Pengguna</h2>
            <a class="btn btn-success" href="{{ route('penggunas.create') }}">Tambah Pengguna</a>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="penggunas-table" style="width: 100%;">
            <thead class="thead-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>ID Telegram</th>
                    <th>Foto SIM</th>
                    <th>Foto KTP</th>
                    <th width="180px">Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
@endsection

<!-- Modal Preview Gambar -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-labelledby="imagePreviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content bg-white border-0">
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 500px;" alt="Preview">
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(function() {
            $('#penggunas-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('penggunas.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'alamat',
                        name: 'alamat'
                    },
                    {
                        data: 'no_hp',
                        name: 'no_hp'
                    },
                    {
                        data: 'id_telegram',
                        name: 'id_telegram'
                    },
                    {
                        data: 'foto_pelanggan',
                        name: 'foto_pelanggan',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'file_ktp',
                        name: 'file_ktp',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                    }
                ]
            });
        });

        function showImagePreview(imgElement) {
            const modalImage = document.getElementById('modalImage');
            modalImage.src = imgElement.src;
            const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
            modal.show();
        }
    </script>
@endpush
