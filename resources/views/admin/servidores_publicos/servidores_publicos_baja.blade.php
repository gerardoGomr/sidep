<?php
use Sidep\Dominio\ServidoresPublicos\MovimientoMotivo;
?>
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
                            <input type="hidden" name="encargoId" class="encargoId">
                            <button type="button" id="confirmarBaja" class="btn btn-primary"><i class="fa fa-minus-square"></i> CONFIRMAR BAJA</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>