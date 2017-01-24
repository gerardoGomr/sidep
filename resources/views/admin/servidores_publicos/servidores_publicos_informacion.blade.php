<div class="tab-pane active" id="informacion">
    <div class="innerAll">
        <div class="row">
            <div class="col-sm-7 col-lg-8">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="box-generic padding-none margin-none">
                            <h5 class="innerAll border-bottom margin-none bg-gray">DATOS DEL ENCARGO</h5>
                            <div class="innerAll">
                                <table class="table table-hover margin-none">
                                    <tbody>
                                        <tr>
                                            <td class="border-top-none strong">DEPENDENCIA:</td>
                                            <td class="border-top-none">{{ $encargo->getDependencia()->getDependencia() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="strong">ADSCRIPCIÓN:</td>
                                            <td>{{ $encargo->getAdscripcion() }}</td>
                                        </tr>
                                        <tr>
                                            <td class="strong">FECHA DE ALTA:</td>
                                            <td>{{ !is_null($encargo->getFechaAlta()) ? \Sidep\Aplicacion\Fecha::fechaDeHoy($encargo->getFechaAlta()) : '' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="strong">ESTATUS:</td>
                                            <td>{{ $encargo->getActivo() }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <div class="box-generic padding-none margin-none">
                            <h5 class="innerAll border-bottom margin-none bg-gray">DATOS DEL SERVIDOR PÚBLICO</h5>
                            <table class="table table-hover margin-none">
                                <tbody>
                                <tr>
                                    <td class="border-top-none strong">CURP:</td>
                                    <td class="border-top-none">{{ $encargo->servidorPublico()->getCurp() }}</td>
                                </tr>
                                <tr>
                                    <td class="strong">RFC:</td>
                                    <td>{{ $encargo->servidorPublico()->getRfc() }}</td>
                                </tr>
                                <tr>
                                    <td class="strong">EDO. CIVIL:</td>
                                    <td>{{ $encargo->servidorPublico()->estadoCivil() }}</td>
                                </tr>
                                <tr>
                                    <td class="strong">DOMICILIO:</td>
                                    <td>{{ $encargo->servidorPublico()->getDomicilio()->direccionCompleta() }}</td>
                                </tr>
                                <tr>
                                    <td class="strong">MUNICIPIO:</td>
                                    <td>{{ $encargo->servidorPublico()->getDomicilio()->getMunicipio() }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-5 col-lg-4">
                <div class="box-generic padding-none">
                    <div class="innerAll">
                        <a href="{{ url('admin/servidores/editar/'. $encargo->servidorPublico()->getId()) }}" class="btn btn-info btn-block"><i class="fa fa-edit"></i> EDITAR DATOS PERSONALES</a>
                        @if($encargo->estaActivo())
                            <button data-id="{{ $encargo->getId() }}" type="button" class="baja btn btn-info btn-block"><i class="fa fa-minus-circle"></i> REGISTRAR BAJA</button>
                            <button type="button" data-id="{{ $encargo->getId() }}" data-adscripcion="{{ $encargo->getAdscripcion() }}" class="promocion btn btn-info btn-block"><i class="fa fa-thumbs-up"></i> REGISTRAR PROMOCIÓN</button>
                            <button type="button" data-id="{{ $encargo->getId() }}" data-adscripcion="{{ $encargo->getAdscripcion() }}" class="cambioAdscripcion btn  btn-info btn-block"><i class="fa fa-share-square"></i> REGISTRAR CAMBIO DE ADSCRIPCIÓN</button>
                        @else
                            <button data-id="{{ $encargo->getId() }}" type="button" class="alta btn btn-info btn-block"><i class="fa fa-plus-circle"></i> REGISTRAR ALTA</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="separator"></div>
        <a href="{{ url('admin/servidores/carta-compromiso/' . $encargo->getId()) }}" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> CARTA COMPROMISO</a>

        <a href="{{ url('admin/servidores/comprobante-cuenta-acceso/' . $encargo->getId() . '/' . base64_encode($encargo->getCuentaAcceso()->getPassword())) }}" target="_blank" class="btn btn-info"><i class="fa fa-print"></i> COMPROBANTE USUARIO Y CONTRASEÑA</a>
    </div>
</div>