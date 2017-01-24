@if (isset($encargos) && !is_null($encargos))
    <table id="tablaResultados" class="table table-bordered table-hover table-primary text-small">
        <thead>
            <tr>
                <th role="columnheader">NOMBRE</th>
                <th role="columnheader">CURP</th>
                <th role="columnheader">RFC</th>
                <th role="columnheader">DOMICILIO</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($encargos as $encargo)
                <tr class="resultados" data-id="{{ $encargo->getServidorPublico()->getId() }}">
                    <td class="nombre">{{ $encargo->getServidorPublico()->nombreCompleto() }}</td>
                    <td class="curp">{{ $encargo->getServidorPublico()->getCurp() }}</td>
                    <td class="rfc">{{ $encargo->getServidorPublico()->getRfc() }}</td>
                    <td class="domicilio">{{ $encargo->getServidorPublico()->getDomicilio()->direccionCompleta() }}</td>
                    <td class="otrosDatos">
                        <input type="hidden" class="fechaNacimiento" value="{{ $encargo->getServidorPublico()->getFechaNacimiento()->format('d/m/Y') }}">
                        <input type="hidden" class="telefono" value="{{ $encargo->getServidorPublico()->getTelefono() }}">
                        <input type="hidden" class="email" value="{{ $encargo->getServidorPublico()->getEmail() }}">
                        <input type="hidden" class="estadoCivil" value="{{ $encargo->getServidorPublico()->estadoCivil() }}">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <style>
        tr.resultados {
            cursor: pointer;
        }

        tr.resultados:hover {
            background: #c0c0c0;
        }
    </style>
@else
    <h5 class="center">NO SE ENCONTRARON COINCIDENCIAS CON EL DATO DE BÚSQUEDA. POR FAVOR, CAPTURE LOS DATOS DEL SERVIDOR PÚBLICO</h5>
@endif