@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h2 class="innerAll bg-white margin-none border-bottom"><i class="fa fa-table"></i> IMPORTAR ALTAS DE SERVIDORES PÚBLICOS</h2>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row row-app">
                                    <div class="col-md-3">
                                        <div class="col-separator">
                                            <h4 class="innerAll bg-gray border-bottom margin-bottom-none">&nbsp;</h4>
                                            <form action="{{ route('servidores-encargo-alta-excel') }}" id="formImportar" method="post" enctype="multipart/form-data">
                                                {!! csrf_field() !!}
                                                <div class="innerAll inner-2x">
                                                    <div class="form-group">
                                                        <label for="archivo" class="control-label">ARCHIVO A IMPORTAR: </label>
                                                        <input type="file" class="form-control required xlsx" name="archivo" id="archivo">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="dependencia" class="control-label">DEPENDENCIA: </label>
                                                        <select name="dependencia" id="dependencia" class="form-control">
                                                            <option value="">SELECCIONE</option>
                                                            @foreach($dependencias as $dependencia)
                                                                <option value="{{ $dependencia->getId() }}">{{ $dependencia->getDependencia() }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="dependencia" class="control-label">FECHA DE MOVIMIENTO: </label>
                                                        <input type="text" name="fechaAlta" id="fechaAlta" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="text-center border-top innerTB">
                                                    <button id="importar" type="submit" class="btn btn-primary"><i class="fa fa-table"></i> Importar excel</button>
                                                </div>
                                            </form>
                                            <div class="col-separator-h"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="col-separator col-separator-last">
                                            <div class="col-table">
                                                <h4 class="innerAll bg-gray border-bottom margin-bottom-none">RESULTADOS DE LA IMPORTACIÓN</h4>
                                                <div class="col-table-row">
                                                    <div class="col-app col-unscrollable">
                                                        <div class="col-app">
                                                            <div class="innerAll" id="resultadoImportacion"></div>
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
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos_encargo_alta_excel.js') }}"></script>
@stop