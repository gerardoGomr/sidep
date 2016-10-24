@if(count($declaraciones) > 0)
    <p class="strong">Se encontraron <span class="text-primary">{{ count($declaraciones) }}</span> resultados.</p>
    <div id="tabla" class="table-responsive" style="overflow: auto;">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <table class="table table-bordered text-small" id="tablaResultados">
            <thead class="bg-primary">
                <tr>
                    <th>&nbsp;</th>
                    <th>FECHA DE REQUERIMIENTO</th>
                    <th>FECHA RECEPCIÓN REQUERIMIENTO</th>
                    <th>NO. REQUERIMIENTO</th>
                    <th>SERVIDOR PÚBLICO</th>
                    <th>CURP</th>
                    <th>DEPENDENCIA</th>
                    <th>ADSCRIPCIÓN</th>
                    <th>TIPO DE DECLARACIÓN</th>
                    <th>ESTATUS</th>
                    <th class="col-md-1">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            @foreach($declaraciones as $declaracion)
                <tr>
                    <td class="columna"><span class="glyphicons {{ $declaracion->requerimientoAbierto() ? 'message_empty' : 'envelope' }}"><i></i></span></td>
                    <td>{{ $declaracion->getRequerimiento()->getFechaGeneracionRequerimiento() }}</td>
                    <td>{{ $declaracion->seHaRegresadoElRequerimiento() ? $declaracion->getOficioRequerimiento()->getFecha() : '-' }}</td>
                    <td>{{ $declaracion->getRequerimiento()->getNumeroRequerimiento() }}</td>
                    <td>{{ $declaracion->getEncargo()->getServidorPublico()->nombreCompleto() }}</td>
                    <td>{{ $declaracion->getEncargo()->getServidorPublico()->getCurp() }}</td>
                    <td>{{ $declaracion->getEncargo()->getDependencia()->getDependencia() }}</td>
                    <td>{{ $declaracion->getEncargo()->getAdscripcion() }}</td>
                    <td>{{ $declaracion->declaracionTipo() }}</td>
                    <td>{{ $declaracion->estatus() }}</td>
                    <td class="text-center actions">
                        <div class="btn-group btn-group-xs">
                            @if(!$declaracion->seHaRegresadoElRequerimiento())
                                <button type="button" class="btn btn-info eliminar" data-id="{{ base64_encode($declaracion->getId()) }}" data-toggle="tooltip" data-original-title="ELIMINAR REQUERIMIENTO" data-placement="top"><i class="fa fa-fw fa-times"></i></button>
                            @else
                                <button type="button" class="btn btn-danger btn-xs desmarcar" data-id="{{ base64_encode($declaracion->getId()) }}" data-toggle="tooltip" data-original-title="DESMARCAR RECEPCIÓN REQUERIMIENTO" data-placement="top"><i class="fa fa-undo"></i></button>
                            @endif
                                <a href="{{ url('admin/declaraciones/requerimientos/pdf/' . base64_encode($declaracion->getId())) }}" class="btn btn-warning pdf" target="_blank" data-toggle="tooltip" data-original-title="GENERAR REQUERIMIENTO EN PDF" data-placement="top"><i class="fa fa-print"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h4>NO HAY REQUERIMIENTOS GENERADOS.</h4>
@endif