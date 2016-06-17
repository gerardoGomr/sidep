@extends('admin.app')

@section('contenido')
    <div class="row row-app widget-employees">
        <div class="col-sm-4 col-md-3">
            <div class="col-separator col-unscrollable box col-separator-first">
                <h4 class="innerAll border-bottom margin-none">Servidores Públicos</h4>

                <div class="innerAll bg-gray">
                    <p class="text-muted strong">
                        INGRESE NOMBRES, CURP, RFC O DEPENDENCIA Y PRESIONE ENTER
                    </p>
                    <form id="formBusqueda" action="{{ route('servidores-busqueda') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="dato" id="dato" class="form-control">
                        </div>
                        <input type="hidden" name="origen" value="index">
                    </form>
                </div>
                <div class="col-table">
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <span id="busquedaServidores" class="hide innerAll"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                                <div id="resultadoBusquedaServidores" data-url="{{ route('servidores-detalle') }}">
                                    @include('admin.servidores_publicos.servidores_publicos_resultado_busqueda')
                                </div>
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
                                <span id="fichaTecnicaLoading" class="hide innerAll"><i class="fa fa-spinner fa-spin"></i></span>
                                <div id="fichaTecnica" class="hide">

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