<h4 class="text-primary">ARCHIVO IMPORTADO CON ÉXITO</h4>
<table class="text-small">
    <tr>
        <td>REGISTROS PROCESADOS: </td>
        <td>{{ $registrosProcesados }}</td>
    </tr>
    <tr>
        <td>SERVIDORES PÚBLICOS IMPORTADOS: </td>
        <td>{{ $registrosImportados }}</td>
    </tr>
    <tr>
        <td>SERVIDORES PÚBLICOS NO IMPORTADOS: </td>
        <td>{{ $registrosNoImportados }}</td>
    </tr>
</table>
<div class="separator border-bottom"></div>
@if(isset($servidoresSinImportar))
    <table class="table table-bordered tablaResultados">
        <thead class="bg-primary">
            <tr>
                <th>NOMBRE</th>
                <th>CURP</th>
                <th>OBSERVACIONES</th>
            </tr>
        </thead>
        <tbody>
            @foreach($servidoresSinImportar as $servidor)
                <tr>
                    <td>{{ $servidor['nombre'] }}</td>
                    <td>{{ $servidor['curp'] }}</td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif