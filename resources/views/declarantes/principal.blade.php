@extends('declarantes.app')

@section('contenido')
    <div class="page-header">
        <div class="fishes">
            <div class="container">
                <h1 class="title">Sistema Integral de Declaraciones Patrimoniales <span>CECCC</span><!-- <span class="version">v 1.0</span> --></h1>
                <h2 class="subtitle">Unidad Ejecutiva y de Situación Patrimonial</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row innerT">
            <div class="col-md-4 col-sm-6 sidebar">
                <div class="panel panel-default">
                    <div class="panel-heading bg-primary">
                        <h4 class="panel-title">Inicio de sesión</h4>
                    </div>
                    <div class="panel-body">
                        <form action="" id="formLogin">
                            <div class="form-group">
                                <label for="username">Nombre de usuario:</label>
                                <input type="text" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña:</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Ingresar &raquo;</button>
                                <a href="{{ url('declarantes/cuenta/nueva-contrasenia') }}" class="btn btn-default" data-toggle="tooltip" data-original-title="Click para seguir las instrucciones">¿Olvidó su contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="panel panel-contact panel-default">
                    <div class="panel-heading bg-container">
                        <h4 class="panel-title strong text-regular">Información de interés</h4>
                    </div>
                    <ul class="panel-body">
                        <li>
                            <i class="fa fa-question-circle pull-left fa-2x"></i>
                            <span>Fundamento legal</span><br>
                            <a href="">Ver información</a>
                        </li>
                        <li>
                            <i class="fa fa-question-circle pull-left fa-2x"></i>
                            <span>Tipos de declaraciones</span><br>
                            <a href="">Ver información</a>
                        </li>
                        <li>
                            <i class="fa fa-question-circle pull-left fa-2x"></i>
                            <span>Sanciones</span><br>
                            <a href="">Ver información</a>
                        </li>
                        <li>
                            <i class="fa fa-question-circle pull-left fa-2x"></i>
                            <span>Declarantes de nuevo ingreso</span><br>
                            <a href="">Ver información</a>
                        </li>
                        <li>
                            <i class="fa fa-question-circle pull-left fa-2x"></i>
                            <span>Manual de usuario</span><br>
                            <a href="">Ver información</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8 col-sm-6">
                <div class="box-generic">
                    <div class="innerAll inner2x">
                        <h2>Si trabajas en:</h2>
                        <ul class="innerAll" style="font-size: 18px;">
                            <li>Centro Estatal de Control de Confianza</li>
                            <li>Procuraduría General de Justicia</li>
                            <li>Secretariado Ejecutivo del Sistema Estatal de Seguridad Pública</li>
                            <li>Centro Estatal de Prevención de la Violencia</li>
                            <li>Subsecretaría de Servicios Estratégicos de Seguridad Pública</li>
                            <li>Secretaría de Seguridad Pública y Protección Ciudadana</li>
                        </ul>
                        <div class="separator"></div>
                        <p class="lead">
                            <i class="fa fa-group fa-2x pull-left"></i>
                            Los artículos 76 párrafo 2° y 78 fracción IV de la Ley de Responsabilidades de los Servidores Públicos del Estado de Chiapas establecen que deberás presentar declaraciones patrimoniales ante el Centro Estatal de Control de Confianza Certificado del Estado de Chiapas.
                        </p>
                    </div>


                    <div class="row">
                        <div class="col-md-4 col-sm-6">
                            <div class="well">
                                Los datos plasmados en las declaraciones de situación patrimonial se encuentran resguardados y protegidos de acuerdo con la LEY QUE GARANTIZA LA TRANSPARENCIA Y DERECHO A LA INFORMACION PÚBLICA PARA EL ESTADO DE CHIAPAS.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop