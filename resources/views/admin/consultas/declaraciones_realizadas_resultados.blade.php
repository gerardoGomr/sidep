@if(count($declaraciones) > 0)
    <p class="strong">Se encontraron <span class="text-primary">{{ count($declaraciones) }}</span> resultados.</p>
    <p class="pull-right">
        <button type="button" class="btn btn-primary excel"><i class="fa fa-table"></i> Exportar a Excel</button>
        {{--<button type="button" class="btn btn-success pdf"><i class="fa fa-table"></i> Exportar a PDF</button>--}}
    </p>
    <div class="clearfix"></div>
    @include('admin.consultas.declaraciones_realizadas_resultados_tabla')
@else
    <h4 class="text-center innerAll text-danger">No se encontraron resultados.</h4>
@endif