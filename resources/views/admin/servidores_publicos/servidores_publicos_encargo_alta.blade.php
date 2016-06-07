@extends('admin.app')

@section('contenido')
    <div class="row row-app">
        <div class="col-md-12">
            <div class="col-separator bg-none col-unscrollable box col-separator-first">
                <div class="col-table">
                    <h4 class="innerAll bg-white margin-none border-bottom">Registrar nuevo encargo a servidor público</h4>
                    <div class="col-separator-h"></div>
                    <div class="col-table-row">
                        <div class="col-app col-unscrollable">
                            <div class="col-app">
                                <div class="row">
                                    <div id="busquedaServidores" class="col-md-12 col-lg-6">
                                        <div class="box-generic padding-none">
                                            <div class="heading-buttons border-bottom innerLR">
                                                <h4 class="margin-none strong innerTB pull-left">Servidor público</h4>
                                                <button id="nuevoServidor" class="btn btn-sm btn-inverse btn-stroke pull-right"><i class="fa fa-plus-square"></i> Es servidor público de nuevo ingreso</button>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="innerAll">
                                                <div class="form-group">
                                                    <label class="control-label">Buscar:</label>
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

                                    <form id="formAltaEncargo" class="form-horizontal">
                                        {!! csrf_field() !!}
                                        <div id="contenedorFormServidor" class="col-md-12 col-lg-6 hide">
                                            <div class="box-generic padding-none animated fadeIn">
                                                <h4 class="strong border-bottom innerAll">Datos del servidor público</h4>
                                                <div class="innerAll">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="box-generic">
                                                                <h5 class="media-heading">Datos personales</h5>
                                                                <div class="separator"></div>
                                                                <div class="form-group">
                                                                    <label for="nombre" class="control-label col-md-3">Nombre:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="nombre" id="nombre" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="paterno" class="control-label col-md-3">A. Paterno:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="paterno" id="paterno" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="materno" class="control-label col-md-3">A. Materno:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="materno" id="materno" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="fechaNacimiento" class="control-label col-md-3">Fecha de nacimiento:</label>
                                                                    <div class="col-md-3 col-lg-4">
                                                                        <input type="text" name="fechaNacimiento" id="fechaNacimiento" class="form-control fecha">
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
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="box-generic">
                                                                <h5 class="media-heading">Datos del domicilio</h5>
                                                                <div class="separator"></div>
                                                                <div class="form-group">
                                                                    <label for="calle" class="control-label col-md-3">Calle:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="calle" id="calle" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="noExterior" class="control-label col-md-3">No. Exterior:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="noExterior" id="noExterior" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="noInterior" class="control-label col-md-3">No. Interior:</label>
                                                                    <div class="col-md-8">
                                                                        <input type="text" name="noInterior" id="noInterior" class="form-control">
                                                                    </div>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="coloniaLocalidad" class="control-label col-md-3">Colonia/Localidad:</label>
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
                                                                    <label for="municipio" class="control-label col-md-3">Municipio:</label>
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

                                        <div id="contenedorFormPrincipal" class="col-md-12 col-lg-6 hide">
                                            <div class="box-generic padding-none animated fadeIn">
                                                <h4 class="strong border-bottom innerAll">Datos del encargo</h4>
                                                <div class="innerAll">
                                                    <div class="separator"></div>
                                                    <div class="form-group">
                                                        <label for="dependencia" class="control-label col-md-3 col-lg-2">Dependencia:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <select name="dependencia" id="dependencia" class="form-control required">
                                                                <option value="">Seleccione</option>
                                                                @foreach($dependencias as $dependencia)
                                                                    <option value="{{ $dependencia->getId() }}">{{ $dependencia->getDependencia() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="puesto" class="control-label col-md-3 col-lg-2">Puesto:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <select name="puesto" id="puesto" class="required" style="width: 100%;">
                                                                <option value="">Seleccione</option>
                                                                @foreach($puestos as $puesto)
                                                                    <option value="{{ $puesto->getId() }}">{{ $puesto->getPuesto() }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group hide" id="campoOtroPuesto">
                                                        <div class="col-md-8 col-lg-9 col-lg-offset-2 col-md-offset-3">
                                                            <input type="text" name="otroPuesto" id="otroPuesto" class="form-control" placeholder="Escriba el puesto del servidor público">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="adscripcion" class="control-label col-md-3 col-lg-2">Adscripción:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <input type="text" name="adscripcion" id="adscripcion" class="form-control required">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="fechaIngreso" class="control-label col-md-3 col-lg-2">Fecha de ingreso:</label>
                                                        <div class="col-md-3 col-lg-3">
                                                            <input type="text" name="fechaIngreso" id="fechaIngreso" class="form-control required fecha" readonly="readonly" value="{{ (new DateTime())->format('d/m/Y')  }}">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="observaciones" class="control-label col-md-3 col-lg-2">Observaciones:</label>
                                                        <div class="col-md-8 col-lg-9">
                                                            <textarea name="observaciones" id="observaciones" rows="5" class="form-control"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-3 col-lg-3 col-md-offset-3">
                                                            <div class="checkbox">
                                                                <label class="checkbox-custom">
                                                                    <input type="checkbox" name="exento" id="exento" class="">
                                                                    <i class="fa fa-circle-o"></i> Exento
                                                                </label>
                                                            </div>
                                                            <span class="text-danger hide" id="textoExento">No se generará declaración</span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-md-8 col-md-offset-3">
                                                            <a href="#" id="guardar" class="btn btn-primary"><i class="fa fa-plus-square"></i> Registrar alta</a>
                                                            <a href="{{ url('admin/servidores') }}" id="cancelar" class="btn btn-default"><i class="fa fa-times"></i> Cancelar registro</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <input type="hidden" id="rutaBase" value="{{ url('admin/servidores') }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{ asset('public/js/servidores_publicos/servidores_publicos_encargo_alta.js') }}"></script>
@stop