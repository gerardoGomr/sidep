@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h2 class="innerAll margin-none bg-white"><i class="fa fa-user"></i> USUARIOS</h2>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    @if(!is_null($encargos))
                                        <a href="#modalAgregarUsuario" data-toggle="modal" class="btn btn-primary"><i class="fa fa-plus-square"></i> AGREGAR NUEVO USUARIO</a>
                                    @else
                                        <a href="#" class="btn btn-primary" disabled><i class="fa fa-plus-square"></i> AGREGAR NUEVO USUARIO</a>
                                    @endif
                                    <div class="separator"></div>

                                    <div id="usuariosRegistrados" data-url="{{ url('admin/usuarios') }}" data-token="{!! csrf_token() !!}">
                                        @if(!is_null($encargosSidep))
                                            @include('admin.usuarios.usuarios_resultados')
                                            <input type="hidden" id="existenUsuarios" value="1">
                                        @else
                                            <h4>NO SE HAN ASIGNADO USUARIOS.</h4>
                                            <input type="hidden" id="existenUsuarios" value="0">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(!is_null($encargos))
        @include('admin.usuarios.usuarios_agregar')
    @endif
    @include('admin.usuarios.usuarios_editar_privilegios')
    @include('admin.loading')
@stop

@section('js')
    <script src="{{ asset('public/js/usuarios/usuarios.js') }}"></script>
@stop