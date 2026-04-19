@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Pengaturan</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('pengaturans.create') }}"> Create New Pengaturan</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Longitude</th>
            <th>Latitude</th>
            <th>Radius</th>
            <th>Keterangan</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($pengaturans as $pengaturan)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $pengaturan->longitude }}</td>
                <td>{{ $pengaturan->latitude }}</td>
                <td>{{ $pengaturan->radius }}</td>
                <td>{{ $pengaturan->keterangan }}</td>
                <td>
                    <form action="{{ route('pengaturans.destroy', $pengaturan->id) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('pengaturans.show', $pengaturan->id) }}">Show</a>

                        <a class="btn btn-primary" href="{{ route('pengaturans.edit', $pengaturan->id) }}">Edit</a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btndanger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $pengaturans->links() !!}
@endsection
