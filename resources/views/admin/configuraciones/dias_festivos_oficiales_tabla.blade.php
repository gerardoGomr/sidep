<?php $i = 0 ?>
<table class="table table-primary table-bordered table-striped" id="tablaDias" data-url-eliminar="{{ url('admin/conf/dias-festivos-eliminar') }}">
    <thead>
    <tr>
        <th>#</th>
        <th>FECHA</th>
        <th>CELEBRACIÓN</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($diasFestivos as $diaFestivo)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $diaFestivo->fecha() }}</td>
            <td>{{ $diaFestivo->celebracion }}</td>
            <td>
                <div class="btn-group btn-group-xs">
                    <button type="button" class="btn btn-info editar" data-fecha="{{ $diaFestivo->fecha }}" data-celebracion="{{ $diaFestivo->celebracion }}" data-id="{{ $diaFestivo->id }}" data-toggle="tooltip" title="EDITAR"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-danger eliminar" data-fecha="{{ $diaFestivo->fecha }}" data-celebracion="{{ $diaFestivo->celebracion }}" data-id="{{ $diaFestivo->id }}" data-toggle="tooltip" title="ELIMINAR"><i class="fa fa-times"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

