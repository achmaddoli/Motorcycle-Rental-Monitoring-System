@extends('sewas.layout')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2> Show Sewa</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('sewas.index') }}"> Back</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID Pengguna:</strong>
                {{ $sewa->id_pengguna }}
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ID Kendaraan:</strong>
                    {{ $sewa->id_kendaraan }}
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Durasi Penyewaan:</strong>
                        {{ $sewa->durasi_penyewaan }}
                    </div>
                </div>
            </div>
        @endsection
