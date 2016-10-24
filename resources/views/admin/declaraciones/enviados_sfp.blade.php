@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator box col-separator-first col-unscrollable">
                <div class="col-table">
                    <h3 class="innerAll">ENVIADOS A SECRETARÍA DE LA FUNCIÓN PÚBLICA</h3>
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
                                                        <label for="dependencia" class="control-label">DEPENDENCIA:</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon"><i class="icon-tag-fill-1 text-faded"></i></span>
                                                            <select name="dependencia" id="dependencia" class="form-control">
                                                                <option value="">TODAS</option>
                                                                @foreach($dependencias as $dependencia)
                                                                    <option value="{{ $dependencia->getId() }}">{{ $dependencia->getDependencia() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="servidor" class="control-label">SERVIDOR PÚBLICO</label>
                                                        <input type="text" name="servidor" id="servidor" class="form-control" placeholder="NOMBRES, CURP, RFC">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-8 col-md-12">
                                                            <div class="form-group">
                                                                <label for="fecha1" class="control-label">ENTRE FECHA:</label>
                                                                <div class="input-group">
                                                                    <input class="form-control fecha" type="text" name="fecha1" id="fecha1" value="" readonly>
                                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fecha2" class="control-label">Y FECHA:</label>
                                                                <div class="input-group">
                                                                    <input class="form-control fecha" type="text" name="fecha2" value="" readonly>
                                                                    <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-center border-top innerTB">
                                                    <button id="buscar" type="button" class="btn btn-primary" data-url="{{ route('enviados-sfp-marcar-buscar') }}"><i class="fa fa-search"></i> BUSCAR</button>
                                                </div>
                                            </form>
                                            <div class="col-separator-h"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="col-separator col-separator-last">
                                            <div class="col-table">
                                                <h4 class="innerAll bg-gray border-bottom margin-bottom-none">ENVIADOS</h4>
                                                <div class="col-table-row">
                                                    <div class="col-app col-unscrollable">
                                                        <div class="col-app">
                                                            <div class="innerAll" id="resultadoBusqueda" data-url="{{ route('sancion-eliminar') }}">
                                                                @include('admin.declaraciones.enviados_sfp_resultados')
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
    <script src="{{ asset('public/js/declaraciones/enviados_sfp.js') }}"></script>
@stop