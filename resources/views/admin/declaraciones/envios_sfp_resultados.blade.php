@if(count($declaraciones) > 0)
    <p class="strong">Se encontraron <span class="text-primary">{{ count($declaraciones) }}</span> resultados.</p>

    <form action="{{ route('enviados-sfp-marcar') }}" id="formMarcar" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="innerAll">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="fechaMarcado">FECHA DE MARCADO:</label>
                        <div class="input-group">
                            <input type="text" class="form-control fecha required" id="fechaMarcado" name="fechaMarcado" readonly>
                            <div class="input-group-btn">
                                <button id="marcar" type="button" class="btn btn-success marcar"><i class="fa fa-check-square"></i> MARCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="tabla" class="table-responsive" style="overflow: auto;">
            <table class="table table-bordered text-small" id="tablaResultados">
                <thead class="bg-primary">
                    <tr>
                        <th>FECHA NUEVO PLAZO</th>
                        <th>REQUERIMIENTO</th>
                        <th>FECHA GENERACIÓN REQUERIMIENTO</th>
                        <th>FECHA RECEPCIÓN REQUERIMIENTO</th>
                        <th>SERVIDOR PÚBLICO</th>
                        <th>CURP</th>
                        <th>DEPENDENCIA</th>
                        <th>ADSCRIPCIÓN</th>
                        <th>TIPO DE DECLARACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($declaraciones as $declaracion)
                    <tr>
                        <td>
                            {{ $declaracion->getRequerimiento()->getFechaPlazoCumplimiento() }}
                            <input type="hidden" name="declaracionId[]" value="{{ base64_encode($declaracion->getId()) }}">
                        </td>
                        <td>{{ $declaracion->getRequerimiento()->getNumeroRequerimiento() }} </td>
                        <td>{{ $declaracion->getRequerimiento()->getFechaGeneracionRequerimiento() }}</td>
                        <td>{{ $declaracion->getOficioRequerimiento()->getFecha() }}</td>
                        <td>{{ $declaracion->getEncargo()->getServidorPublico()->nombreCompleto() }}</td>
                        <td>{{ $declaracion->getEncargo()->getServidorPublico()->getCurp() }}</td>
                        <td>{{ $declaracion->getEncargo()->getDependencia()->getDependencia() }}</td>
                        <td>{{ $declaracion->getEncargo()->getAdscripcion() }}</td>
                        <td>{{ $declaracion->declaracionTipo() }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </form>
@else
    <h5>NO EXISTEN DECLARACIONES DISPONIBLES PARA ENVIAR A LA SECRETARÍA DE LA FUNCIÓN PÚBLICA.</h5>
@endif