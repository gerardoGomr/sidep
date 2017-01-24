<?php
use \Sidep\Dominio\Usuarios\UsuarioTipo;
?>
<div class="modal fade" id="modalAgregarUsuario" role="dialog" aria-labelledby="modalTitle" aria-hidden="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="width: 700px;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrarModal">&times;</button>
                <h3 class="modal-title" id="modalTitle">AGREGAR USUARIO</h3>
            </div>
            <div class="modal-body">
                <form action="{{ url('admin/usuarios/nuevo') }}" id="formBusquedaServidores" class="form-horizontal">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="servidorPublico" class="control-label col-md-3">SERVIDOR PÚBLICO:</label>
                        <div class="col-md-8">
                            <select name="encargo" id="encargo" style="width: 100%;" class="required">
                                <option value="">SELECCIONE</option>
                                @foreach($encargos as $encargo)
                                    <option value="{{ $encargo->getId() }}">{{ $encargo->getServidorPublico()->nombreCompleto() }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="separator border-bottom"></div>
                    <div id="resultadoServidores" style="max-height: 400px; overflow-y: auto">

                    </div>

                    <div class="separator"></div>
                    <div class="form-group">
                        <label for="tipoUsuario" class="control-label col-md-3">TIPO DE USUARIO:</label>
                        <div class="col-md-8">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="tipoUsuario" value="{{ UsuarioTipo::JEFE }}" class="required"> JEFE DE UNIDAD
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="tipoUsuario" value="{{ UsuarioTipo::ANALISTA }}" class="required"> ANALISTA SITUACIÓN PATRIMONIAL
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-3">
                            <button class="btn btn-primary" id="crearUsuario" type="button"><i class="fa fa-save"></i> CREAR USUARIO</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>