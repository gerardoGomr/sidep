@if (isset($encargos) && !is_null($encargos))
    <table id="tablaResultados" class="table table-hover">
        <thead>
        <tr>
            <th>Nombre</th>
            <th>CURP</th>
            <th>RFC</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($encargos->elementos() as $encargo)
                <tr class="resultados">
                    <td>{{ $encargo->getServidorPublico()->nombreCompleto() }}</td>
                    <td>{{ $encargo->getServidorPublico()->getCurp() }}</td>
                    <td>{{ $encargo->getServidorPublico()->getRfc() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h5>No se encontraron resultados.</h5>
@endif