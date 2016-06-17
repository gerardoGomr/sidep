<div class="tab-pane" id="movimientos">
    <table class="table table-bordered">
        <thead class="bg-primary">
            <tr>
                <th>FECHA</th>
                <th>TIPO MOVIMIENTO</th>
                <th>COMENTARIO</th>
            </tr>
        </thead>
        <tbody>
            @foreach($encargo->getMovimientos()->getValues() as $movimiento)
                <tr>
                    <td>{{ $movimiento->getFecha() }}</td>
                    <td>{{ $movimiento->movimientoTipo() }}</td>
                    <td>{{ $movimiento->getComentario() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>