@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator bg-none col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h4 class="innerAll bg-white margin-none border-bottom">REGISTRAR NUEVO ENCARGO A SERVIDOR PÚBLICO</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row">
                                    <div id="contenedorDatosServidor" class="col-md-8 hide">
                                        <div class="box-generic padding-none animated fadeIn">
                                            <dl class="dl-horizontal innerAll">
                                                <dt>Servidor público</dt>
                                                <dd>ADRIÁN GÓMEZ ORDAZ</dd>

                                                <dt>CURP:</dt>
                                                <dd>GOOA153010HCSMZR07</dd>

                                                <dt>RFC:</dt>
                                                <dd>GOOA153010</dd>

                                                <dt>Domicilio:</dt>
                                                <dd>AV. BARRIO COLÓN ENTRE BLVD. TUXTLÁN Y CALLE CERRADA 261 C. P. 29059, TUXTLA GUTIÉRREZ</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="busquedaServidores" class="col-md-12 col-lg-8">
                                        <div class="box-generic padding-none">
                                            <div class="heading-buttons border-bottom innerLR">
                                                <h4 class="margin-none strong innerTB pull-left">SERVIDOR PÚBLICO</h4>
                                                <!--<button id="nuevoServidor" class="btn btn-sm btn-inverse btn-stroke pull-right"><i class="fa fa-plus-square"></i> Es servidor público de nuevo ingreso</button>-->
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="innerAll">
                                                <div class="form-group">
                                                    <label class="control-label">BUSCAR:</label>
                                                    <div class="input-group">
                                                        <input type="text" name="servidor" id="servidor" class="form-control" placeholder="Ingrese nombres, RFC, CURP o dependencia">
                                                        <a href="" id="buscarServidor" class="input-group-addon"><i class="fa fa-search"></i></a>
                                                    </div>
                                                </div>
                                                <div class="separator"></div>
                                                <span id="loadingBusqueda" class="hide"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                                                <div id="resultadosBusqueda">
                                                    @include('admin.servidores_publicos.servidores_publicos_encargo_resultados')
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <form id="formAltaEncargo" class="form-horizontal" action="{{ route('servidores-encargo-alta') }}">
                                        {!! csrf_field() !!}
                                        <div id="contenedorFormServidor" class="col-md-12 col-lg-8 hide">
                                            <div class="box-generic padding-none animated fadeIn">
                                                <h4 class="strong border-bottom innerAll">DATOS DEL SERVIDOR PÚBLICO</h4>
                                                <div class="innerAll">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="box-generic">
                                                                <h5 class="media-heading">DATOS PERSONALES</h5>
                                                                <div class="separator"></div>
                                                                <div class="form-group">
                                                                    <label for="nombre" class="control-label col-md-3">NOMBRE:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="nombre" id="nombre" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="paterno" class="control-label col-md-3">A. PATERNO:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="paterno" id="paterno" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="materno" class="control-label col-md-3">A. MATERNO:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="materno" id="materno" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="fechaNacimiento" class="control-label col-md-3">F. NACIMIENTO:</label>
                                                                    <div class="col-md-3 col-lg-4">
                                                                        <input type="text" name="fechaNacimiento" id="fechaNacimiento" class="form-control fecha" readonly="readonly">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="curp" class="control-label col-md-3">CURP:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="curp" id="curp" class="form-control" maxlength="18">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="rfc" class="control-label col-md-3">RFC:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="rfc" id="rfc" class="form-control" maxlength="13">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="telefono" class="control-label col-md-3">TELÉFONO:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="telefono" id="telefono" class="form-control" placeholder="">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="email" class="control-label col-md-3">E-MAIL:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="email" id="email" class="form-control noUpperCase" placeholder="ejemplo@dominio.com.mx">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="box-generic">
                                                                <h5 class="media-heading">DATOS DEL DOMICILIO</h5>
                                                                <div class="separator"></div>
                                                                <div class="form-group">
                                                                    <label for="calle" class="control-label col-md-3">CALLE:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="calle" id="calle" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="noExterior" class="control-label col-md-3">NUM. EXTERIOR:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="noExterior" id="noExterior" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="noInterior" class="control-label col-md-3">NUM. INTERIOR:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="noInterior" id="noInterior" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="coloniaLocalidad" class="control-label col-md-3">COLONIA-LOCALIDAD:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="coloniaLocalidad" id="coloniaLocalidad" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="cp" class="control-label col-md-3">C. P.:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="cp" id="cp" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="municipio" class="control-label col-md-3">MUNICIPIO:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="municipio" id="municipio" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="contenedorFormPrincipal" class="col-md-12 col-lg-8 hide">
                                            <div class="box-generic padding-none animated fadeIn">
                                                <h4 class="strong border-bottom innerAll">DATOS DEL ENCARGO</h4>
                                                <div class="innerAll">
                                                    <div class="separator"></div>
                                                    <div class="form-group">
                                                        <label for="dependencia" class="control-label col-md-3 col-lg-2">DEPENDENCIA:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <select name="dependencia" id="dependencia" class="form-control required">
                                                                <option value="">SELECCIONE</option>
                                                                @foreach($dependencias as $dependencia)
                                                                    <option value="{{ $dependencia->getId() }}">{{ $dependencia->getDependencia() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="puesto" class="control-label col-md-3 col-lg-2">PUESTO:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <select name="puesto" id="puesto" class="required" style="width: 100%;">
                                                                <option value="">SELECCIONE</option>
                                                                @foreach($puestos as $puesto)
                                                                    <option value="{{ $puesto->getId() }}">{{ $puesto->getPuesto() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group hide" id="campoOtroPuesto">
                                                        <div class="col-md-8 col-lg-9 col-lg-offset-2 col-md-offset-3">
                                                            <input type="text" name="otroPuesto" id="otroPuesto" class="form-control" placeholder="ESCRIBA EL PUESTO DEL SERVIDOR PÚBLICO">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="adscripcion" class="control-label col-md-3 col-lg-2">ADSCRIPCIÓN:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input type="text" name="adscripcion" id="adscripcion" class="form-control required">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fechaIngreso" class="control-label col-md-3 col-lg-2">FECHA DE INGRESO:</label>
                                                        <div class="col-md-3 col-lg-3">
                                                            <input type="text" name="fechaIngreso" id="fechaIngreso" class="form-control required fecha" readonly="readonly" value="{{ (new DateTime())->format('d/m/Y')  }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="observaciones" class="control-label col-md-3 col-lg-2">OBSERVACIONES:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <textarea name="observaciones" id="observaciones" rows="5" class="form-control"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-3 col-lg-3 col-md-offset-3">
                                                            <div class="checkbox">
                                                                <label class="checkbox-custom">
                                                                    <input type="checkbox" name="exento" id="exento" class="">
                                                                    <i class="fa fa-circle-o"></i> EXENTO
                                                                </label>
                                                            </div>
                                                            <span class="text-danger hide" id="textoExento">NO SE GENERARÁ DECLARACIÓN INICIAL</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-8 col-md-offset-3">
                                                            <a href="#" id="guardar" class="btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR ALTA</a>
                                                            <a href="{{ url('admin/servidores') }}" id="cancelar" class="btn btn-default"><i class="fa fa-times"></i> CANCELAR REGISTRO</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="servidorRegistrado" id="servidorRegistrado">
                                            <input type="hidden" name="idServidorPublico" id="idServidorPublico" value="">
                                        </div>
                                    </form>
                                </div>
                                <input type="hidden" id="rutaBase" value="{{ url('admin/servidores') }}">
                                <input type="hidden" id="rutaBusqueda" value="{{ route('servidores-busqueda') }}">
                            </div>

                            <div class="innerAll">
                                @if ($errors->any())
                                    @foreach ($errors->all() as $error)
                                        <p class="error">{{ $error }}</p>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="loadingGuardar" class="modal fade hide" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <span><i class="fa fa-spinner fa-spin fa-2x"></i> REGISTRANDO DATOS DEL ENCARGO; POR FAVOR, ESPERE...</span>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos_encargo_alta.js') }}"></script>
@stop