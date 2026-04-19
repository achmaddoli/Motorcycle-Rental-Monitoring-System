@extends('penggunas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex justify-content-between align-items-center">
            <h2>Edit Monitoring</h2>
            <a class="btn btn-primary" href="{{ route('monitorings.index') }}">Back</a>
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

    <form action="{{ route('monitorings.update', $monitoring->id) }}" method="POST" class="mt-4">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>ID Kendaraan:</strong>
                    <input type="text" name="id_kendaraan" value="{{ $monitoring->id_kendaraan }}" class="form-control"
                        placeholder="ID Kendaraan">
                </div>
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-group">
                    <strong>Longitude:</strong>
                    <input type="text" name="longitude" value="{{ $monitoring->longitude }}" class="form-control"
                        placeholder="Longitude">
                </div>
            </div>

            <div class="col-md-12 mb-4">
                <div class="form-group">
                    <strong>Latitude:</strong>
                    <input type="text" name="latitude" value="{{ $monitoring->latitude }}" class="form-control"
                        placeholder="Latitude">
                </div>
            </div>

            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-success">Submit</button>
            </div>
        </div>
    </form>
@endsection
