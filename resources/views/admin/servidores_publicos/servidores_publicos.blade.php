<?php
 use Sidep\Dominio\ServidoresPublicos\MovimientoMotivo;
?>
@extends('admin.app')

@section('contenido')
    <div class="row row-app widget-employees">
        <div class="col-sm-4 col-md-3">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
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
            <div class="col-separator col-unscrollable box bg-none">
                <div class="col-table">
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <span id="fichaTecnicaLoading" class="hide innerAll"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                                <div id="fichaTecnica" class="hide">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalMotivoBaja" role="dialog" aria-labelledby="modalTitle" aria-hidden="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrarModal">&times;</button>
                    <h3 class="modal-title" id="modalTitle">BAJA DE SERVIDOR PÚBLICO</h3>
                </div>
                <div class="modal-body">
                    <form action="{{ route('encargo-baja') }}" id="formBaja" class="form-horizontal">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <label for="motivo" class="control-label col-md-3">MOTIVO DE BAJA:</label>
                            <div class="col-md-8">
                                <select name="motivo" id="motivo" class="required form-control">
                                    <option value="">SELECCIONE</option>
                                    <option value="{{ MovimientoMotivo::TERMINO_ENCARGO }}">TERMINO DEL ENCARGO</option>
                                    <option value="{{ MovimientoMotivo::FALLECIMIENTO }}">FALLECIMIENTO</option>
                                    <option value="{{ MovimientoMotivo::PROCESO }}">PROCESO</option>
                                    <option value="{{ MovimientoMotivo::RECLUSION }}">RECLUSIÓN</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fechaBaja" class="control-label col-md-3">FECHA DE BAJA:</label>
                            <div class="col-md-2">
                                <input type="text" name="fechaBaja" id="fechaBaja" class="form-control required" readonly="readonly" value="{{ (new DateTime())->format('d/m/Y')  }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-3">
                                <input type="hidden" name="encargoId" id="encargoId">
                                <button type="button" id="confirmarBaja" class="btn btn-primary"><i class="fa fa-minus-square"></i> CONFIRMAR BAJA</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingGuardar" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <span><i class="fa fa-spinner fa-spin fa-4x"></i> REGISTRANDO DATOS DEL ENCARGO; POR FAVOR, ESPERE...</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos.js') }}"></script>
@stop