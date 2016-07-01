<?php
use Sidep\Dominio\ServidoresPublicos\EstadoCivil;
?>

@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h4 class="innerAll bg-white margin-none border-bottom">EDITAR DATOS PERSONALES DE SERVIDOR PÚBLICO</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row">
                                    <div class="col-md-12 col-lg-8">
                                        <div class="innerAll">
                                            <form id="formEditarDatos" class="form-horizontal" action="{{ route('servidores-editar') }}">
                                                {!! csrf_field() !!}
                                                <div class="widget" id="contenedorServidorPublico">
                                                    <div class="widget-head">
                                                        <h4 class="innerAll">SERVIDOR PÚBLICO</h4>
                                                    </div>
                                                    <div class="widget-body">
                                                        <div class="box-generic">
                                                            <h5>DATOS PERSONALES</h5>
                                                            <div class="form-group">
                                                                <label for="nombre" class="control-label col-md-3">NOMBRE:</label>
                                                                <div class="col-md-3">
                                                                    <input type="text" name="nombre" id="nombre" class="required form-control" placeholder="NOMBRE" value="{{ $servidor->getNombre() }}">
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <input type="text" name="paterno" id="paterno" class="required form-control" placeholder="A. PATERNO" value="{{ $servidor->getPaterno() }}">
                                                                </div>

                                                                <div class="col-md-2">
                                                                    <input type="text" name="materno" id="materno" class="form-control" placeholder="A. MATERNO" value="{{ $servidor->getMaterno() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="fechaNacimiento" class="control-label col-md-3">F. NACIMIENTO:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="fechaNacimiento" id="fechaNacimiento" class="form-control fecha" readonly="readonly" value="{{ !is_null($servidor->getFechaNacimiento()) ? $servidor->getFechaNacimiento()->format('d/m/Y') : '' }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="curp" class="control-label col-md-3">CURP:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <input type="text" name="curp" id="curp" class="required form-control" maxlength="18" placeholder="18 CARACTERES" value="{{ $servidor->getCurp() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="rfc" class="control-label col-md-3">RFC:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <input type="text" name="rfc" id="rfc" class="required form-control" maxlength="13" placeholder="ADJE896425 AU7" value="{{ $servidor->getRfc() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="telefono" class="control-label col-md-3">TELÉFONO:</label>
                                                                <div class="col-md-3 col-lg-4">
                                                                    <input type="text" name="telefono" id="telefono" class="numerosEnteros form-control" placeholder="61 8 93 00" value="{{ $servidor->getTelefono() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">E-MAIL:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <input type="text" name="email" id="email" class="email form-control noUpperCase" placeholder="ejemplo@dominio.com.mx" value="{{ $servidor->getEmail() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="email" class="control-label col-md-3">ESTADO CIVIL:</label>
                                                                <div class="col-md-4 col-lg-5">
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::CASADO }}" {{ $servidor->getEstadoCivil() === EstadoCivil::CASADO ? 'checked="checked"' : '' }}> CASADO (A)
                                                                        </label>
                                                                    </div>
                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::SOLTERO }}" {{ $servidor->getEstadoCivil() === EstadoCivil::SOLTERO ? 'checked="checked"' : '' }}> SOLTERO (A)
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::UNION_LIBRE }}" {{ $servidor->getEstadoCivil() === EstadoCivil::UNION_LIBRE ? 'checked="checked"' : '' }}> UNIÓN LIBRE
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::DIVORCIADO }}" {{ $servidor->getEstadoCivil() === EstadoCivil::DIVORCIADO ? 'checked="checked"' : '' }}> DIVORCIADO (A)
                                                                        </label>
                                                                    </div>

                                                                    <div class="radio">
                                                                        <label>
                                                                            <input type="radio" name="estadoCivil" class="required" value="{{ EstadoCivil::VIUDO }}" {{ $servidor->getEstadoCivil() === EstadoCivil::VIUDO ? 'checked="checked"' : '' }}> VIUDO (A)
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="box-generic">
                                                            <h5>DATOS DEL DOMICILIO</h5>

                                                            <div class="form-group">
                                                                <label for="calle" class="control-label col-md-3">CALLE:</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="calle" id="calle" class="required form-control" value="{{ $servidor->getDomicilio()->getCalle() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="noExterior" class="control-label col-md-3">NUM. EXTERIOR:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="noExterior" id="noExterior" class="required form-control" value="{{ $servidor->getDomicilio()->getNoExterior() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="noInterior" class="control-label col-md-3">NUM. INTERIOR:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="noInterior" id="noInterior" class="form-control" value="{{ $servidor->getDomicilio()->getNoInterior() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="coloniaLocalidad" class="control-label col-md-3">COLONIA / LOCALIDAD:</label>
                                                                <div class="col-md-8">
                                                                    <input type="text" name="coloniaLocalidad" id="coloniaLocalidad" class="required form-control" value="{{ $servidor->getDomicilio()->getLocalidadColonia() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="cp" class="control-label col-md-3">C. P.:</label>
                                                                <div class="col-md-2">
                                                                    <input type="text" name="cp" id="cp" class="required form-control" placeholder="29000" value="{{ $servidor->getDomicilio()->getCodigoPostal() }}">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="municipio" class="control-label col-md-3">MUNICIPIO:</label>
                                                                <div class="col-md-5 col-lg-6">
                                                                    <input type="text" name="municipio" id="municipio" class="required form-control" value="{{ $servidor->getDomicilio()->getMunicipio() }}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="hidden" name="idServidorPublico" id="idServidorPublico" value="{{ $servidor->getId() }}">
                                                </div>

                                                <div class="form-group">
                                                    <div class="col-md-8 col-md-offset-3">
                                                        <a href="#" id="guardar" class="btn btn-primary"><i class="fa fa-edit"></i> GUARDAR CAMBIOS</a>
                                                        <a href="{{ url('admin/servidores') }}" id="cancelar" class="btn btn-default"><i class="fa fa-times"></i> CANCELAR EDICIÓN</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos_editar.js') }}"></script>
@stop