@if(count($declaraciones) > 0)
    <p class="strong">SE ENCONTRARON <span class="text-primary">{{ count($declaraciones) }}</span> RESULTADOS.</p>
    <button type="button" class="btn btn-primary excel pull-right"><i class="fa fa-table"></i> EXPORTAR A EXCEL</button>

    <div class="clearfix"></div>

    <form action="{{ route('omisos-marcar') }}" id="formMarcar" class="form-horizontal">
        {!! csrf_field() !!}
        <div class="row">
            <div class="col-md-4">
                <div class="innerAll">
                    <div class="form-group">
                        <label for="fechaMarcado">FECHA DE MARCADO:</label>
                        <div class="input-group">
                            <input type="text" class="form-control fecha required" id="fechaMarcado" name="fechaMarcado" readonly>
                            <div class="input-group-btn">
                                <button id="marcar" type="button" class="btn btn-success marcar"><i class="fa fa-check-square"></i> MARCAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.consultas.omisos_resultados_tabla')
    </form>
@else
    <h4 class="text-center innerAll text-danger">NO SE ENCONTRARON RESULTADOS.</h4>
@endif