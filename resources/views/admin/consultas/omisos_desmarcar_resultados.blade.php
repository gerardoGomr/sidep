@if(count($declaraciones) > 0)
    <p class="strong">SE ENCONTRARON <span class="text-primary">{{ count($declaraciones) }}</span> RESULTADOS.</p>

    <div style="max-height: 500px; overflow-y: auto" id="tabla">
        <table id="tablaResultados" class="table table-bordered text-small">
            <thead class="bg-primary">
            <tr>
                <th>SERVIDOR PÚBLICO</th>
                <th>CURP</th>
                <th>DEPENDENCIA</th>
                <th>ADSCRIPCIÓN</th>
                <th>TIPO DE DECLARACIÓN</th>
                <th>FECHA GENERACIÓN REQUERIMIENTO</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($declaraciones as $declaracion)
                <tr>
                    <td>{{ $declaracion->getEncargo()->getServidorPublico()->nombreCompleto() }}</td>
                    <td>{{ $declaracion->getEncargo()->getServidorPublico()->getCurp() }}</td>
                    <td>{{ $declaracion->getEncargo()->getDependencia()->getDependencia() }}</td>
                    <td>{{ $declaracion->getEncargo()->getAdscripcion() }}</td>
                    <td>{{ $declaracion->declaracionTipo() }}</td>
                    <td>{{ $declaracion->getFechaGeneracionRequerimiento() }}</td>
                    <td><button type="button" class="btn btn-info btn-xs desmarcar" data-id="{{ base64_encode($declaracion->getId()) }}" data-toggle="tooltip" data-original-title="DESMARCAR OMISO" data-placement="left"><i class="fa fa-undo"></i></button></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@else
    <h4 class="text-center innerAll text-danger">NO SE ENCONTRARON RESULTADOS.</h4>
@endif