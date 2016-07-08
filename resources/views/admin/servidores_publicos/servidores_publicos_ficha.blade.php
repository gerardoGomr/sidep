<div class="box-generic margin-none padding-none">
    <div class="innerAll border-bottom">
        <h4 class="margin-none pull-left">{{ $encargo->servidorPublico()->nombreCompleto() }}</h4>
        <div class="clearfix"></div>
    </div>

    <p class="margin-none innerTB half innerAll"><i class="fa fa-certificate text-primary"></i>&nbsp; {{ $encargo->getPuesto()->getPuesto() }}</p>
</div>
<div class="col-separator-h"></div>

<div class="widget widget-tabs">
    <div class="widget-head">
        <ul>
            <li class="active"><a href="#informacion" data-toggle="tab"><i class="fa fa-user"></i> INFORMACIÓN</a></li>
            <li class=""><a href="#movimientos" data-toggle="tab"><i class="fa fa-refresh"></i> MOVIMIENTOS</a></li>
            <li class=""><a href="#declaraciones" data-toggle="tab"><i class="fa fa-list-ol"></i> DECLARACIONES</a></li>
            {{--<li class=""><a href="#anotaciones" data-toggle="tab"><i class="fa fa-edit"></i> ANOTACIONES</a></li>--}}
        </ul>
    </div>
    <div class="widget-body">
        <div class="tab-content">
            @include('admin.servidores_publicos.servidores_publicos_informacion')
            @include('admin.servidores_publicos.servidores_publicos_movimientos')
            @include('admin.servidores_publicos.servidores_publicos_declaraciones')
            
        </div>
    </div>
</div>