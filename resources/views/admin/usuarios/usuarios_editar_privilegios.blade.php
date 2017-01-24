<div class="modal fade" id="modalPrivilegios" role="dialog" aria-labelledby="modalTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrarModal">&times;</button>
                <h3 class="modal-title" id="modalTitle">EDITAR PRIVILEGIOS DE <span id="nombreUsuario"></span></h3>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/usuarios/privilegios') }}" id="formPrivilegios" class="form-horizontal">
                    {{ csrf_field() }}
                    <div id="cuerpoFormPrivilegios"></div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button class="btn btn-primary" id="asignarPrivilegios" type="button"><i class="fa fa-save"></i> ASIGNAR PRIVILEGIOS</button>
                        </div>
                    </div>
                    <input type="hidden" name="encargoId" id="encargoId" value="">
                </form>
            </div>
        </div>
    </div>
</div>