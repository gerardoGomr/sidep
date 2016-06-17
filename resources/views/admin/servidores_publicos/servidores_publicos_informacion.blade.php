<div class="tab-pane active" id="informacion">
    <div class="innerAll">
        <div class="row">
            <div class="col-sm-7 col-lg-8">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <div class="box-generic padding-none margin-none">
                            <h5 class="innerAll border-bottom margin-none">DATOS DEL ENCARGO</h5>
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
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td class="strong">ACTIVO:</td>
                                        <td>Si</td>
                                    </tr>
                                    <tr>
                                        <td class="strong">PROCESO:</td>
                                        <td>No</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-6">
                        <div class="box-generic padding-none margin-none">
                            <h5 class="innerAll border-bottom margin-none">DATOS DEL SERVIDOR PÚBLICO</h5>
                            <table class="table table-striped margin-none">
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
                                    <td>Unión libre</td>
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
                <h5 class="innerAll border-top border-right border-left margin-none bg-gray">MOVIMIENTOS</h5>
                <div id="acciones" class="btn-group btn-group btn-group-vertical btn-group-block">
                    <a href="" class="btn btn-default"><i class="fa fa-edit"></i> Editar datos personales</a>
                    <a href="" class="btn btn-default"><i class="fa fa-minus-circle"></i> Registrar baja</a>
                    <a href="" class="btn btn-default"><i class="fa fa-thumbs-up"></i> Registrar promoción</a>
                    <a href="" class="btn btn-default"><i class="fa fa-share-square"></i> Registrar cambio de adscripción</a>
                </div>

                <div class="separator"></div>
                <div class="box-generic margin-none padding-none">
                    <h5 class="innerAll border-bottom">Estatus del servidor público</h5>
                    <div class="form-group innerAll">
                        <div class="checkbox">
                            <label class="checkbox-custom">
                                <input type="checkbox" name="estatus">
                                <i class="fa fa-circle-o"></i> Exento
                            </label>
                        </div>
                        <div class="checkbox">
                            <label class="checkbox-custom">
                                <input type="checkbox" name="estatus">
                                <i class="fa fa-circle-o"></i> Proceso
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>