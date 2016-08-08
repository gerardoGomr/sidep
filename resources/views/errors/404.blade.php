@extends('app')

@section('contenido')
    <div class="row error">
        <div class="col-md-4 col-md-offset-1 center">
            <div class="center">
                <img src="../assets//images/error-icon-bucket.png " class="error-icon"/>
            </div>
        </div>
        <div class="col-md-5 content center">
            <h1 class="strong">LO SENTIMOS</h1>
            <h4 class="innerB">LA PÁGINA SOLICITADA NO EXISTE.</h4>
            <div class="well">
                {{ $error }}
            </div>
        </div>
    </div>
@stop