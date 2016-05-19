@extends('admin.app')

@section('contenido')
    <div class="row row-app widget-employees">
        <div class="row row-app">
            <div class="col-sm-4 col-md-3">
                <div class="col-separator col-unscrollable box col-separator-first">
                    <h4 class="innerAll border-bottom margin-none">Servidores Públicos</h4>

                    <div class="innerAll bg-gray">
                        <p class="text-muted strong">
                            Para buscar a servidores públicos, ingrese nombre, RFC, CURP o dependencia a la que pertenece y presione ENTER.
                        </p>
                        <form id="formBusqueda" action="{{ url('buscar') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <input type="text" name="servidor" id="servidor" class="form-control" placeholder="Ingrese nombres, RFC, CURP o dependencia">
                            </div>
                        </form>
                    </div>
                    <div class="col-table">
                        <div class="col-table-row">
                            <div class="col-app col-unscrollable">
                                <div class="col-app">
                                    <span id="busquedaServidores" style="display:none;" class="innerAll"><i class="fa fa-spinner fa-spin"></i></span>
                                    <ul id="servidoresPublicos" class="list-group list-group-1 borders-none">
                                        @include('admin.servidores_publicos.servidores_publicos_resultado_busqueda')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8 col-md-9">
                <div class="col-separator col-separator-last box bg-none">
                    <div class="col-table">
                        <div class="col-table-row">
                            <div class="col-app col-unscrollable">
                                <div class="col-app">
                                    <span id="fichaTecnicaLoading" style="display:none;" class="innerAll"><i class="fa fa-spinner fa-spin"></i></span>
                                    <div id="fichaTecnica" style="display:none;">
                                        @include('admin.servidores_publicos.servidores_publicos_ficha')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos.js') }}"></script>
@stop