@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator box col-separator-first col-unscrollable">
                <div class="col-table">
                    <h3 class="innerAll">REPORTE DEL DÍA</h3>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row row-app">
                                    <div class="col-md-3">
                                        <div class="col-separator">
                                            <h4 class="innerAll bg-gray border-bottom margin-bottom-none">BUSCADOR</h4>
                                            <form role="form" action="{{ route('reporte-del-dia-exportar') }}" id="formFiltro" method="post">
                                                {!! csrf_field() !!}
                                                <div class="innerAll inner-2x">
                                                    <div class="form-group">
                                                        <label for="dependencia" class="control-label">DEPENDENCIA:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icon-tag-fill-1 text-faded"></i></span>
                                                            <select name="dependencia" id="dependencia" class="form-control">
                                                                <option value="">SELECCIONE</option>
                                                                @foreach($dependencias as $dependencia)
                                                                    <option value="{{ $dependencia->getId() }}">{{ $dependencia->getDependencia() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-12">
                                                            <div class="form-group">
                                                                <label for="fecha1" class="control-label">ENTRE FECHA:</label>
                                                                <div class="input-group">
                                                                    <input class="form-control fecha required" type="text" name="fecha1" id="fecha1" value="" readonly>
                                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fecha2" class="control-label">Y FECHA:</label>
                                                                <div class="input-group">
                                                                    <input class="form-control fecha required" type="text" name="fecha2" value="" readonly>
                                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center border-top innerTB">
                                                    <button id="buscar" type="button" class="btn btn-primary" data-url="{{ route('reporte-del-dia-buscar') }}"><i class="fa fa-search"></i> Buscar</button>
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
                                                            <div class="innerAll" id="resultadoBusqueda"></div>
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
@stop

@include('admin.loading')

@section('js')
    <script src="{{ asset('public/js/consultas/reporte_del_dia.js') }}"></script>
@stop