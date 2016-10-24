@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator box col-separator-first col-unscrollable">
                <div class="col-table">
                    <h3 class="innerAll">REPORTE DE MODIFICACIÓN</h3>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row row-app">
                                    <div class="col-md-3">
                                        <div class="col-separator">
                                            <h4 class="innerAll bg-gray border-bottom margin-bottom-none">BUSCADOR</h4>
                                            <form role="form" action="" id="formFiltro" method="post">
                                                {!! csrf_field() !!}
                                                <div class="innerAll inner-2x">
                                                    <div class="form-group">
                                                        <label for="periodo" class="control-label">PERIODO:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icon-tag-fill-1 text-faded"></i></span>
                                                            <select name="periodo" id="periodo" class="required form-control">
                                                                <option value="">SELECCIONE</option>
                                                                <option value="1">ENERO</option>
                                                                <option value="2">JULIO</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="anio" class="control-label">AÑO:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icon-tag-fill-1 text-faded"></i></span>
                                                            <select name="anio" id="periodo" class="required form-control">
                                                                <option value="">SELECCIONE</option>
                                                                @if (count($anios) > 0)
                                                                    @foreach($anios as $anio)
                                                                        <option value="{{ $anio }}">{{ $anio }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center border-top innerTB">
                                                    <button id="buscar" type="button" class="btn btn-primary" data-url="{{ route('enviados-sfp-marcar-buscar') }}"><i class="fa fa-search"></i> BUSCAR</button>
                                                    <input type="hidden" name="opcion" id="opcion">
                                                </div>
                                            </form>
                                            <div class="col-separator-h"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="col-separator col-separator-last">
                                            <div class="col-table">
                                                <h4 class="innerAll bg-gray border-bottom margin-bottom-none">RESULTADOS</h4>
                                                <div class="col-table-row">
                                                    <div class="col-app col-unscrollable">
                                                        <div class="col-app">
                                                            <div class="innerAll" id="resultadoBusqueda" data-url="{{ route('sancion-eliminar') }}">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.loading')
@stop

@section('js')
    <script src="{{ asset('public/js/reportes/reporte_modificacion.js') }}"></script>
@stop