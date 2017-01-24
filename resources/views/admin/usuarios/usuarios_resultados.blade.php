<?php $i = 1; ?>
<table class="table table-primary table-bordered table-striped" id="tablaUsuarios" data-url="{{ url('admin/usuarios/privilegios/editar') }}">
    <thead>
    <tr>
        <th>#</th>
        <th>NOMBRE</th>
        <th>PUESTO</th>
        <th>ADSCRIPCIÓN</th>
        <th>NOMBRE DE USUARIO</th>
        <th>ESTATUS</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($encargosSidep as $encargo)
        <tr>
            <td>{{ $i++ }}</td>
            <td>{{ $encargo->getServidorPublico()->nombreCompleto() }}</td>
            <td>{{ $encargo->getPuesto()->getPuesto() }}</td>
            <td>{{ $encargo->getAdscripcion() }}</td>
            <td>{{ $encargo->getCuentaAcceso()->getUsername() }}</td>
            <td>
                @if($encargo->estaActivo())
                    <span class="label label-success text-larger">Activo</span>
                @else
                    <span class="label label-danger text-larger">Inactivo / baja</span>
                @endif
            </td>
            <td>
                <div class="btn-group btn-group-xs">
                    <button class="btn btn-info editarPrivilegios" data-nombre="{{ $encargo->getServidorPublico()->nombreCompleto() }}" data-id="{{ $encargo->getId() }}" type="button" data-toggle="tooltip" title="EDITAR PRIVILEGIOS"><i class="fa fa-sort-amount-desc"></i></button>
                    <button class="btn btn-danger" type="button" data-toggle="tooltip" title="REMOVER USUARIO"><i class="fa fa-times"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>