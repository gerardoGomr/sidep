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
    @foreach($movimientos as $movimiento)
        <tr>
            <td>{{ $movimiento->getEncargo()->getServidorPublico()->nombreCompleto() }}</td>
            <td>{{ $movimiento->getEncargo()->getServidorPublico()->getCurp() }}</td>
            <td>{{ $movimiento->getEncargo()->getDependencia()->getDependencia() }}</td>
            <td>{{ $movimiento->getEncargo()->getAdscripcion() }}</td>
            <td>{{ $movimiento->movimientoTipo() }}</td>
            <td>{{ $movimiento->getFecha() }}</td>
            <td></td>
        </tr>
    @endforeach
    </tbody>
</table>