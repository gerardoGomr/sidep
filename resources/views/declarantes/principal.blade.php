@extends('declarantes.app')

@section('contenido')
    <div class="container">
        <div class="row row-app margin-none">
            <div class="col-md-4 col-sm-6">
                <div class="col-separator col-unscrollable box col-separator-first">
                    <div class="col-table">
                        <div class="col-table-row">
                            <div class="col-app col-unscrollable">
                                <div class="col-app">
                                    <h4 class="bg-gray innerAll">Login</h4>
                                    <div class="innerAll">
                                        <div class="form-group">
                                            <label for="username" class="control-label">Nombre de usuario:</label>
                                            <input type="text" name="username" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="control-label">Contraseña</label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Ingresar &raquo;</button>
                                            <a href="" class="btn btn-default" data-toggle="tooltip" data-original-title="Click para seguir las instrucciones">¿Olvidó su contraseña?</a>
                                        </div>
                                    </div>
                                    <div class="col-separator-h"></div>
                                    <div class="box-generic padding-none">
                                        <h4 class="bg-gray innerAll">Información de interés</h4>
                                        <div class="innerAll">
                                            <ul class="nav nav-pills nav-pills-gray nav-stacked">
                                                <li><a href="">Fundamento legal</a></li>
                                                <li><a href="">Tipos de declaraciones</a></li>
                                                <li><a href="">Sanciones</a></li>
                                                <li><a href="">Declarantes de nuevo ingreso</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 col-sm-6">
                <div class="col-separator col-unscrollable box bg-none">
                    <div class="col-table">
                        <div class="col-table-row">
                            <div class="col-app col-unscrollable">
                                <div class="col-app">
                                    <div class="box-generic">
                                        <h2>Sistema Integral de Declaraciones Patrimoniales</h2>
                                        <div style="font-size: 14pt;">
                                            <p>Si trabajas en:</p>
                                            <ul>
                                                <li>Centro Estatal de Control de Confianza</li>
                                                <li>Procuraduría General de Justicia</li>
                                                <li>Secretariado Ejecutivo del Sistema Estatal de Seguridad Pública</li>
                                                <li>Centro Estatal de Prevención de la Violencia</li>
                                                <li>Subsecretaría de Servicios Estratégicos de Seguridad Pública</li>
                                                <li>Secretaría de Seguridad Pública y Protección Ciudadana</li>
                                            </ul>
                                            <p>
                                                Los artículos 76 párrafo 2° y 78 fracción IV de la Ley de Responsabilidades de los Servidores Públicos del Estado de Chiapas establecen que deberás presentar declaraciones patrimoniales ante el Centro Estatal de Control de Confianza Certificado del Estado de Chiapas.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-6">
                                            <div class="widget widget-inverse">
                                                <div class="widget-body">
                                                    Los datos plasmados en las declaraciones de situación patrimonial se encuentran resguardados y protegidos de acuerdo con la LEY QUE GARANTIZA LA TRANSPARENCIA Y DERECHO A LA INFORMACION PÚBLICA PARA EL ESTADO DE CHIAPAS
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="widget widget-inverse">
                                                <div class="widget-body">
                                                    Los datos plasmados en las declaraciones de situación patrimonial se encuentran resguardados y protegidos de acuerdo con la LEY QUE GARANTIZA LA TRANSPARENCIA Y DERECHO A LA INFORMACION PÚBLICA PARA EL ESTADO DE CHIAPAS
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 col-sm-6">
                                            <div class="widget widget-inverse">
                                                <div class="widget-body">
                                                    Los datos plasmados en las declaraciones de situación patrimonial se encuentran resguardados y protegidos de acuerdo con la LEY QUE GARANTIZA LA TRANSPARENCIA Y DERECHO A LA INFORMACION PÚBLICA PARA EL ESTADO DE CHIAPAS
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