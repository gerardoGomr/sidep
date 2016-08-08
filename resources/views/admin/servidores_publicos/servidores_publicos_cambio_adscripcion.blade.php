<div class="modal fade" id="modalCambioAdscripcion" role="dialog" aria-labelledby="modalTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrarModal">&times;</button>
                <h3 class="modal-title" id="modalTitle">CAMBIO DE ADSCRIPCIÓN</h3>
            </div>
            <div class="modal-body">
                <p>
                    <span class="strong">ADSCRIPCIÓN ACTUAL: </span>
                    <span id="adscripcionActual"></span>
                </p>
                <form action="{{ route('encargo-cambio-adscripcion') }}" id="formCambioAdscripcion" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="motivo" class="control-label col-md-3">*ADSCRIPCIÓN NUEVA:</label>
                        <div class="col-md-8">
                            <input type="text" name="adscripcion" class="form-control required">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3 col-md-offset-3">
                            <input type="hidden" name="encargoId" class="encargoId">
                            <button type="button" id="actualizarAdscripcion" class="btn btn-primary"><i class="fa fa-floppy-o"></i> ACTUALIZAR ADSCRIPCIÓN</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>