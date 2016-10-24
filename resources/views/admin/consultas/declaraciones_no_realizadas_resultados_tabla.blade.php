<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table id="tablaResultados" class="display text-small">
    <thead>
    <tr>
        <th>SERVIDOR PÚBLICO</th>
        <th>CURP</th>
        <th>DEPENDENCIA</th>
        <th>ADSCRIPCIÓN</th>
        <th>TIPO DE MOVIMIENTO</th>
        <th>FECHA DE MOVIMIENTO</th>
        <th>USUARIO</th>
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
            <td>{{ $declaracion->estatus() }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>