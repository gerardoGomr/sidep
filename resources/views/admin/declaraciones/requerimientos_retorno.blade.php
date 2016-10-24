@extends('admin.app')

@section('contenido')
    <div class="row row-app widget-employees">
        <div class="col-md-3">
            <div class="col-separator col-separator-first box col-unscrollable">
                <div class="col-table">
                    <h4 class="innerAll bg-gray border-bottom margin-bottom-none">BUSCADOR</h4>
                    <form role="form" action="{{ route('requerimientos-retorno-buscar') }}" id="formFiltro" method="post">
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
                        </div>
                        <div class="text-center innerTB">
                            <button id="buscar" type="button" class="btn btn-primary" data-url="{{ route('omisos-buscar') }}"><i class="fa fa-search"></i> BUSCAR</button>
                        </div>
                    </form>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div id="resultadoBusqueda"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="col-separator col-unscrollable box">
                <div class="col-table">
                    <h4 class="innerAll bg-gray border-bottom margin-bottom-none">DECLARACIONES - OMISOS</h4>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    <form action="{{ route('requerimientos-retorno-marcar') }}" id="formOmisos">
                                        {!! csrf_field() !!}
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="numeroOficio" class="control-label">NÚMERO DE OFICIO:</label>
                                                    <input type="text" name="numeroOficio" id="numeroOficio" class="form-control required">
                                                </div>

                                                <div class="form-group">
                                                    <label for="fechaOficio" class="control-label">FECHA DE OFICIO:</label>
                                                    <input type="text" name="fechaOficio" id="fechaOficio" class="form-control required" readonly>
                                                </div>
                                                <div class="text-center innerTB">
                                                    <button id="guardar" type="button" class="btn btn-primary" data-url=""><i class="fa fa-floppy-o"></i> MARCAR RETORNO</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="separator border-top"></div>
                                        <div id="tabla" class="table-responsive">
                                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                                            <table class="table table-bordered text-small hide" id="tablaResultados">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th>SERVIDOR PÚBLICO</th>
                                                        <th>CURP</th>
                                                        <th>DEPENDENCIA</th>
                                                        <th>TIPO DE DECLARACIÓN</th>
                                                        <th>&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody">

                                                </tbody>
                                            </table>
                                        </div>
                                    </form>
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
    <script src="{{ asset('public/js/declaraciones/requerimientos_retorno.js') }}"></script>
@stop