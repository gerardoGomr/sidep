@extends('admin.app')

@section('contenido')
    <div class="row error">
        <div class="col-md-4 col-md-offset-1 center">
            <div class="center">
                <img src="{{ asset('public/img/warning-error.png') }}" class="error-icon">
            </div>
        </div>
        <div class="col-md-5 content center">
            <h1 class="strong">LO SENTIMOS</h1>
            <div class="well">
                {{ $error }}
            </div>

            <a href="{{ url('admin') }}" class="btn btn-primary btn-lg"><i class="fa fa-home"></i> VOLVER AL INICIO</a>
        </div>
    </div>
@stop