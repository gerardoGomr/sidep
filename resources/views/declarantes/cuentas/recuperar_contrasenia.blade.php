@extends('declarantes.app')

@section('contenido')
    <div class="page-title">
        <div class="container">
            <h1>Recuperar contraseña</h1>
        </div>
    </div>

    <div class="container">
        <p class="innerTB">Ingrese por favor el nombre de usuario que le fue asignado al darle su alta y después de click en el botón Siguiente.</p>
        <div class="box-generic bg-gray innerAll inner-2x" id="paso1">
            <div id="busquedaUsuario">
                <div class="row margin-none">
                    <div class="col-sm-8 col-xs-10 padding-none">
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Nombre de Usuario: Ejemplo: GORG87552">
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-2 padding-none">
                        <div class="innerAll">
                            <button type="button" class="btn btn-default btn-lg" id="noRecuerdoUsuario">No recuerdo mi nombre de usuario</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="otraBusqueda" class="hide">
                <div class="row margin-none">
                    <div class="col-sm-8 col-xs-10 padding-none">
                        <label for="dependencia" class="control-label">Dependencia en la que labora:</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="fa fa-building fa-fw"></i></span>
                            <select name="dependencia" id="dependencia" class="form-control">
                                <option value="">Seleccione</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-4 col-xs-2 padding-none">
                        <div class="innerAll">
                            <button type="button" class="btn btn-default btn-lg" id="cancelarPorNombreDeUsuario">Buscar por nombre de usuario</button>
                        </div>
                    </div>
                </div>
                <div class="separator"></div>
                <div class="row margin-none">
                    <div class="col-sm-8 col-xs-10 padding-none">
                        <label for="curp" class="control-label">CURP:</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-addon"><i class="fa fa-list fa-fw"></i></span>
                            <input type="text" class="form-control" name="curp" id="curp">
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator"></div>
            <button type="button" class="btn btn-primary btn-lg" id="irAPaso2">Siguiente <i class="fa fa-chevron-right fa-fw"></i></button>
        </div>

        <div class="box-generic bg-gray innerAll inner2-x" id="paso2">
            <h3>Servidor público</h3>
            <table class="table">
                <tr>
                    <td class="strong">Nombre:</td>
                    <td>Gerardo Adrián Gómez Ruiz</td>
                </tr>
                <tr>
                    <td class="strong">Dependencia:</td>
                    <td>Centro Estatal de Control de Confianza Certificado</td>
                </tr>
                <tr>
                    <td class="strong">Correo electrónico:</td>
                    <td>xxx@hotmail.com</td>
                </tr>
            </table>

            <p>
                Se enviará la contraseña al correo electrónico registrado. <span class="text-primary">xxx@hotmail.com</span> |
                <button type="button" class="btn btn-default"><i class="fa fa-arrow-right"></i> Enviar a otro correo electrónico</button>
            </p>
            <form action="" class="form-horizontal">
                <div class="form-group">
                    <label for="nuevoMail" class="col-md-2 control-label">Nuevo email:</label>
                    <div class="col-md-5">
                        <input type="text" name="nuevoMail" id="nuevoMail" class="form-control">
                    </div>
                </div>
            </form>

            <div class="separator"></div>
            <button type="button" class="btn btn-primary btn-lg" id="enviar">Enviar contraseña &raquo;</button>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/js/declarantes/recuperar_contrasenia.js') }}"></script>
@stop