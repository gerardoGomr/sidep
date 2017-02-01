@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-6">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h2 class="innerAll margin-none bg-white"><i class="fa fa-calendar"></i> DÍAS FESTIVOS NO OFICIALES - DEL AÑO EN CURSO</h2>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    <button type="button" id="modalAgregarDiaFestivo" class="btn btn-primary"><i class="fa fa-plus-square"></i> AGREGAR NUEVO DÍA FESTIVO</button>

                                    <div class="separator"></div>

                                    <div id="diasFestivos" data-url="{{ url('admin/conf/dias-festivos-no-oficiales') }}" data-token="{!! csrf_token() !!}">
                                        @if($diasFestivos->count() > 0)
                                            @include('admin.configuraciones.dias_festivos_no_oficiales_tabla')
                                            <input type="hidden" id="existenDiasFestivos" value="1">
                                        @else
                                            <h4>Aún no se agregan días festivos.</h4>
                                            <input type="hidden" id="existenDiasFestivos" value="0">
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

    <div class="modal fade" id="modalAgregarDia" role="dialog" aria-labelledby="modalTitle" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrarModal">&times;</button>
                    <h3 class="modal-title" id="modalTitle">AGREGAR NUEVO DÍA FESTIVO NO OFICIAL</h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('dia-festivo-no-oficial-agregar') }}" id="formDiaFestivo" class="form-horizontal">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="dia" class="control-label col-md-3">DÍA:</label>
                            <div class="col-md-3">
                                <input type="text" name="dia" id="dia" class="form-control required" readonly>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="celebracion" class="control-label col-md-3">CELEBRACIÓN:</label>
                            <div class="col-md-8">
                                <input type="text" name="celebracion" id="celebracion" class="form-control required" placeholder="EJEMPLO: BATALLA DE PUEBLA">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-3">
                                <input type="hidden" name="diaFestivoId" id="diaFestivoId" value="">
                                <button type="button" id="agregarDiaFestivo" class="btn btn-primary"></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('admin.loading')
@stop

@section('js')
    <script src="{{ asset('public/js/configuraciones/dias_festivos_no_oficiales.js') }}"></script>
@stop