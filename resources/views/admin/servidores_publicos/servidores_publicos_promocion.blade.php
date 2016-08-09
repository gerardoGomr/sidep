<div class="modal fade" id="modalPromocion" role="dialog" aria-labelledby="modalTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrarModal">&times;</button>
                <h3 class="modal-title" id="modalTitle">PROMOCIÓN</h3>
            </div>
            <div class="modal-body">
                <form action="{{ route('encargo-promocion') }}" id="formPromocion" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="motivo" class="control-label col-md-3">*NUEVO PUESTO:</label>
                        <div class="col-md-8">
                            <select name="puesto" id="puesto" class="required" style="width: 100%;">
                                <option value="">SELECCIONE</option>
                                @foreach($puestos as $puesto)
                                    <option value="{{ $puesto->getId() }}">{{ $puesto->getPuesto() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="motivo" class="control-label col-md-3">*ADSCRIPCIÓN NUEVA:</label>
                        <div class="col-md-8">
                            <input type="text" name="adscripcion" class="form-control required adscripcion">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fechaMovimiento" class="control-label col-md-3">FECHA DE MOVIMIENTO:</label>
                        <div class="col-md-2">
                            <input type="text" name="fechaMovimiento" id="fechaMovimiento" class="form-control required fecha" readonly="readonly" value="{{ (new DateTime())->format('d/m/Y')  }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-3">
                            <input type="hidden" name="encargoId" class="encargoId">
                            <input type="hidden" id="rutaCartaCompromiso" value="{{ url('admin/servidores/carta-compromiso') }}">
                            <button type="button" id="realizarPromocion" class="btn btn-primary"><i class="fa fa-floppy-o"></i> REALIZAR PROMOCIÓN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>