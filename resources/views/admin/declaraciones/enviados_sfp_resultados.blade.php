@if(count($declaraciones) > 0)
    <p class="strong">Se encontraron <span class="text-primary">{{ count($declaraciones) }}</span> resultados.</p>

    <div id="tabla" class="table-responsive" style="overflow: auto;">
        <table class="table table-bordered text-small" id="tablaResultados">
            <thead class="bg-primary">
                <tr>
                    <th>FECHA DE GENERACIÓN DE SANCIÓN</th>
                    <th>FECHA PLAZO</th>
                    <th>FECHA NUEVO PLAZO</th>
                    <th>SERVIDOR PÚBLICO</th>
                    <th>CURP</th>
                    <th>DEPENDENCIA</th>
                    <th>ADSCRIPCIÓN</th>
                    <th>TIPO DE DECLARACIÓN</th>
                    <th class="col-md-1">&nbsp;</th>
                </tr>
            </thead>
            <tbody>
            @foreach($declaraciones as $declaracion)
                <tr>
                    <td>{{ $declaracion->getFechaEnvioFuncionPublica() }}</td>
                    <td>{{ $declaracion->getFechaPlazo() }}</td>
                    <td>{{ $declaracion->getRequerimiento()->getFechaPlazoCumplimiento() }}</td>
                    <td>{{ $declaracion->getEncargo()->getServidorPublico()->nombreCompleto() }}</td>
                    <td>{{ $declaracion->getEncargo()->getServidorPublico()->getCurp() }}</td>
                    <td>{{ $declaracion->getEncargo()->getDependencia()->getDependencia() }}</td>
                    <td>{{ $declaracion->getEncargo()->getAdscripcion() }}</td>
                    <td>{{ $declaracion->declaracionTipo() }}</td>
                    <td class="text-center actions">
                        <div class="btn-group btn-group-xs">
                            <button type="button" class="btn btn-info eliminar" data-id="{{ base64_encode($declaracion->getId()) }}" data-toggle="tooltip" data-original-title="ELIMINAR SANCIÓN" data-placement="top"><i class="fa fa-fw fa-times"></i></button>
                            <a href="{{ url('admin/declaraciones/enviados-sfp/pdf/' . base64_encode($declaracion->getId())) }}" class="btn btn-warning pdf" target="_blank" data-toggle="tooltip" data-original-title="GENERAR OFICIO EN PDF" data-placement="top"><i class="fa fa-print"></i></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h5>NO EXISTEN DECLARACIONES ENVIADAS A LA SECRETARÍA DE LA FUNCIÓN PÚBLICA.</h5>
@endif