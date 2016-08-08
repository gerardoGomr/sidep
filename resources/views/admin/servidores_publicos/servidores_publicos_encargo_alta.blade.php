<?php
use Sidep\Dominio\ServidoresPublicos\EstadoCivil;
?>

@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h4 class="innerAll bg-white margin-none border-bottom">REGISTRAR NUEVO ENCARGO A SERVIDOR PÚBLICO</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="innerAll">
                                            <div class="widget" id="contenedorBusquedaServidorPublico">
                                                <div class="widget-head">
                                                    <h4 class="innerAll">SERVIDOR PÚBLICO</h4>
                                                </div>
                                                <div class="widget-body">
                                                    <form class="form-horizontal">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-3 col-lg-3" for="datoServidor">BUSCAR SERVIDOR POR:</label>
                                                            <div class="col-md-8 col-lg-8">
                                                                <div class="input-group">
                                                                    <input type="text" name="datoServidor" id="datoServidor" class="form-control" placeholder="PUEDE BUSCAR POR NOMBRES, CURP, RFC O DEPENDENCIA">
                                                                    <a href="" id="buscarServidor" class="input-group-addon"><i class="fa fa-search"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>

                                                    <span id="loadingBusqueda" class="hide"><i class="fa fa-spinner fa-spin fa-2x"></i></span>
                                                    <a href="#resultadosServidor" id="abrirModal" data-toggle="modal" class="hide"></a>

                                                </div>
                                            </div>

                                            <form id="formAltaEncargo" class="form-horizontal" action="{{ route('servidores-encargo-alta') }}">
                                                {!! csrf_field() !!}
                                                <div class="widget hide" id="contenedorServidorPublico">
                                                    <div class="widget-head">
                                                        <h4 class="innerAll">SERVIDOR PÚBLICO</h4>
                                                    </div>
                                                    <div class="widget-body">
                                                        <button id="cambiarServidor" class="btn btn-default" type="button"><i class="fa fa-arrow-left"></i> Cambiar servidor público</button>
                                                        <div class="separator"></div>
                                                        <div id="capturaDatosPersonales" class="hide box-generic">
                                                            <h5>DATOS PERSONALES</h5>
                                                            <div class="form-group">
                                                                <label for="nombre" class="control-label col-md-3">NOMBRE:</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="NOMBRE">
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <input type="text" name="paterno" id="paterno" class="form-control" placeholder="A. PATERNO">
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <input type="text" name="materno" id="materno" class="form-control" placeholder="A. MATERNO">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fechaNacimiento" class="control-label col-md-3">F. NACIMIENTO:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="fechaNacimiento" id="fechaNacimiento" class="form-control fecha" readonly="readonly">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="curp" class="control-label col-md-3">CURP:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <input type="text" name="curp" id="curp" class="form-control" maxlength="18" placeholder="18 CARACTERES">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="rfc" class="control-label col-md-3">RFC:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <input type="text" name="rfc" id="rfc" class="form-control" maxlength="13" placeholder="ADJE896425 AU7">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="telefono" class="control-label col-md-3">TELÉFONO:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <input type="text" name="telefono" id="telefono" class="form-control" placeholder="61 8 93 00">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">E-MAIL:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <input type="text" name="email" id="email" class="form-control noUpperCase" placeholder="ejemplo@dominio.com.mx">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">ESTADO CIVIL:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::CASADO }}"> CASADO (A)
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::SOLTERO }}"> SOLTERO (A)
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::UNION_LIBRE }}"> UNIÓN LIBRE
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::DIVORCIADO }}"> DIVORCIADO (A)
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::VIUDO }}"> VIUDO (A)
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="capturaDatosDomicilio" class="hide box-generic">
                                                            <h5>DATOS DEL DOMICILIO</h5>

                                                            <div class="form-group">
                                                                <label for="calle" class="control-label col-md-3">CALLE:</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="calle" id="calle" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="noExterior" class="control-label col-md-3">NUM. EXTERIOR:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="noExterior" id="noExterior" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="noInterior" class="control-label col-md-3">NUM. INTERIOR:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="noInterior" id="noInterior" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="coloniaLocalidad" class="control-label col-md-3">COLONIA / LOCALIDAD:</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="coloniaLocalidad" id="coloniaLocalidad" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="cp" class="control-label col-md-3">C. P.:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="cp" id="cp" class="form-control" placeholder="29000">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="municipio" class="control-label col-md-3">MUNICIPIO:</label>
                                                                <div class="col-md-5 col-lg-6">
                                                                    <input type="text" name="municipio" id="municipio" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="presentaDatosPersonales" class="hide">
                                                            <div class="separator"></div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-3">NOMBRE:</label>
                                                                <div class="col-md-3">
                                                                    <span id="presentaNombre"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fechaNacimiento" class="control-label col-md-3">F. NACIMIENTO:</label>
                                                                <div class="col-md-2">
                                                                    <span id="presentaFechaNacimiento"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="curp" class="control-label col-md-3">CURP:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <span id="presentaCurp"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="rfc" class="control-label col-md-3">RFC:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <span id="presentaRfc"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="telefono" class="control-label col-md-3">TELÉFONO:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <span id="presentaTelefono"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">E-MAIL:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <span id="presentaEmail"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">ESTADO CIVIL:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <span id="presentaEstadoCivil"></span>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">DOMICILIO:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <span id="presentaDomicilio"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="widget">
                                                    <div class="widget-head">
                                                        <h4 class="innerAll">ENCARGO DE SERVIDOR PÚBLICO</h4>
                                                    </div>
                                                    <div class="widget-body">
                                                        <div class="form-group">
                                                            <label for="dependencia" class="control-label col-md-3">DEPENDENCIA:</label>
                                                            <div class="col-md-8">
                                                                <select name="dependencia" id="dependencia" class="form-control required">
                                                                    <option value="">SELECCIONE</option>
                                                                    @foreach($dependencias as $dependencia)
                                                                        <option value="{{ $dependencia->getId() }}">{{ $dependencia->getDependencia() }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="puesto" class="control-label col-md-3">PUESTO:</label>
                                                            <div class="col-md-8">
                                                                <select name="puesto" id="puesto" class="required" style="width: 100%;">
                                                                    <option value="">SELECCIONE</option>
                                                                    @foreach($puestos as $puesto)
                                                                        <option value="{{ $puesto->getId() }}">{{ $puesto->getPuesto() }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group hide" id="campoOtroPuesto">
                                                            <div class="col-md-8 col-lg-offset-2 col-md-offset-3">
                                                                <input type="text" name="otroPuesto" id="otroPuesto" class="form-control" placeholder="ESCRIBA EL PUESTO DEL SERVIDOR PÚBLICO">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="adscripcion" class="control-label col-md-3">ADSCRIPCIÓN:</label>
                                                            <div class="col-md-8">
                                                                <input type="text" name="adscripcion" id="adscripcion" class="form-control required">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="fechaIngreso" class="control-label col-md-3">FECHA DE INGRESO:</label>
                                                            <div class="col-md-2">
                                                                <input type="text" name="fechaIngreso" id="fechaIngreso" class="form-control required fecha" readonly="readonly" value="{{ (new DateTime())->format('d/m/Y')  }}">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="observaciones" class="control-label col-md-3">OBSERVACIONES:</label>
                                                            <div class="col-md-8">
                                                                <textarea name="observaciones" id="observaciones" rows="5" class="form-control"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="exento" class="control-label col-md-3">ESTATUS DEL SERVIDOR:</label>
                                                            <div class="col-md-3">
                                                                <div class="checkbox">
                                                                    <label class="checkbox-custom">
                                                                        <input type="checkbox" name="exento" id="exento" class="">
                                                                        <i class="fa fa-circle-o"></i> EXENTO
                                                                    </label>
                                                                </div>
                                                                <span class="text-danger hide" id="textoExento">NO SE GENERARÁ DECLARACIÓN INICIAL</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="servidorRegistrado" id="servidorRegistrado">
                                                    <input type="hidden" name="idServidorPublico" id="idServidorPublico" value="">
                                                    <input type="hidden" id="busquedaServidor" value="0">
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-3">
                                                        <a href="#" id="guardar" class="btn btn-primary"><i class="fa fa-plus-square"></i> REGISTRAR ALTA</a>
                                                        <a href="{{ url('admin/servidores') }}" id="cancelar" class="btn btn-default"><i class="fa fa-times"></i> CANCELAR REGISTRO</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="rutaBase" value="{{ url('admin/servidores') }}">
                                <input type="hidden" id="rutaBusqueda" value="{{ route('servidores-busqueda') }}">
                                <input type="hidden" id="rutaCartaCompromiso" value="{{ url('admin/servidores/carta-compromiso') }}">
                                <input type="hidden" id="rutaComprobanteCuentaAcceso" value="{{ url('admin/servidores/comprobante-cuenta-acceso') }}">
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

    <div id="resultadosServidor" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" id="cerrrModal">&times;</button>
                    <h3 class="modal-title" id="modalTitle">RESULTADOS DE LA BÚSQUEDA</h3>
                </div>
                <div class="modal-body" id="resultadosBusqueda">

                </div>
            </div>
        </div>
    </div>

    @include('admin.loading')
@stop

@section('js')
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos_encargo_alta.js') }}"></script>
@stop