<div class="tab-pane" id="declaraciones">
    <table class="table table-bordered">
        <thead class="bg-primary">
        <tr>
            <th>FECHA DECLARACIÓN</th>
            <th>TIPO</th>
            <th>FECHA DE PLAZO</th>
        </tr>
        </thead>
        <tbody>
        @foreach($encargo->getDeclaraciones()->getValues() as $declaracion)
            <tr>
                <td>{{ $declaracion->getFechaGeneracion() }}</td>
                <td>{{ $declaracion->declaracionTipo() }}</td>
                <td>{{ $declaracion->getFechaPlazo() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>