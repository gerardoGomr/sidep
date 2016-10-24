@extends('declarantes.app_iframe')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable col-separator-first">
                <div class="col-table">
                    <h4 class="innerAll">Baja de encargo</h4>
                    <div class="col-separator-h"></div>

                    <div class="col-table-row">
                        <div class="col-app coll-unscrollable">
                            <div class="col-app">
                                <div class="innerAll">
                                    <div class="box-generic animated">
                                        <p class="strong text-medium text-primary">Estimado {{ $encargo->getServidorPublico()->nombreCompleto() }}:</p>
                                        <table>
                                            <tr>
                                                <td class="strong">Fecha de baja:</td>
                                                <td>--</td>
                                            </tr>
                                            <tr>
                                                <td class="strong">Dependencia:</td>
                                                <td>{{ $encargo->getDependencia()->getDependencia() }}</td>
                                            </tr>
                                            <tr>
                                                <td class="strong">Adscripción:</td>
                                                <td>{{ $encargo->getAdscripcion() }}</td>
                                            </tr>
                                        </table>
                                        <p>
                                            Con fundamento en lo dispuesto en los <strong class="text-primary">Artículos 76, 77 y 78 de la Ley de Responsabilidades de los servidores Públicos en el Estado de Chiapas vigente</strong>, le comunicamos que debe realizar su <strong class="text-primary">declaración de conclusión</strong>  ante el Centro Estatal de Control de Confianza Certificado a través del sistema web <strong class="text-primary">SIDEP (Sistema Integral de Declaraciones Patrimoniales C3), debido a la baja del encargo que desempeñaba.</strong>.
                                        </p>
                                        <p>
                                            Puede ingresar al portal del sistema dando click al vínculo: <a href="https://www.declara.chiapas.gob.mx">https://www.declara.chiapas.gob.mx</a>
                                        </p>
                                        <p class="text-primary strong">Le recordamos que debe realizar su declaración patrimonial en tiempo y forma para evitar sanciones</p>
                                        <p class="center strong">ATENTAMENTE</p>
                                        <p class="center">UNIDAD DE SITUACIÓN PATRIMONIAL DEL CENTRO ESTATAL DE CONTROL DE CONFIANZA CERTIFICADO DEL ESTADO DE CHIAPAS</p>

                                        <p class="text-smaill">
                                            Aclaración de dudas, información o asesorías sobre el uso del sistema DeclaraChiapas, comunicarse la Unidad Ejecutiva y de Situación Patrimonial del Centro Estatal de Control de Confianza Certificado, a los telefonos 61 8 93 00 extensión 64009 y 64115, 01 800 2299 000 o vía correo electrónico a  <pre><span class="text-primary">regpatrimonial@controldeconfianza.chiapas.gob.mx</span></pre> y <pre><span class="text-primary">dirpatrimonial@controldeconfianza.chiapas.gob.mx</span></pre>.
                                        </p>
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