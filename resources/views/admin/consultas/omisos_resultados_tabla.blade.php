<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div style="max-height: 500px; overflow-y: auto" id="tabla">
    <table id="tablaResultados" class="table table-bordered text-small">
        <thead class="bg-primary">
        <tr>
            <th>SERVIDOR PÚBLICO</th>
            <th>CURP</th>
            <th>DEPENDENCIA</th>
            <th>ADSCRIPCIÓN</th>
            <th>TIPO DE DECLARACIÓN</th>
            <th>ESTATUS DE DECLARACIÓN</th>
            <th>FECHA GENERACIÓN</th>
        </tr>
        </thead>
        <tbody>
        @foreach($declaraciones as $declaracion)
            <tr>
                <td>
                    {{ $declaracion->getEncargo()->getServidorPublico()->nombreCompleto() }}
                    <input type="hidden" name="declaracionId[]" value="{{ base64_encode($declaracion->getId()) }}">
                </td>
                <td>{{ $declaracion->getEncargo()->getServidorPublico()->getCurp() }}</td>
                <td>{{ $declaracion->getEncargo()->getDependencia()->getDependencia() }}</td>
                <td>{{ $declaracion->getEncargo()->getAdscripcion() }}</td>
                <td>{{ $declaracion->declaracionTipo() }}</td>
                <td>{{ $declaracion->estatus() }}</td>
                <td>{{ $declaracion->getFechaGeneracion() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>