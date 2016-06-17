@if(isset($encargos) && !is_null($encargos))
    <ul id="servidoresPublicos" class="list-group list-group-1 borders-none">
        @foreach($encargos as $encargo)
            <li class="list-group-item animated fadeInUp" data-id="{{ base64_encode($encargo->getId()) }}">
                <div class="media innerAll">
                    <div class="media-body innerT half">
                        <p class="strong margin-none padding-none text-primary">{{ $encargo->servidorPublico()->nombreCompleto() }}</p>
                        <ul class="text-small list-unstyled">
                            <li><i class="fa fa-building-o"></i> Centro Estatal de Control de Confianza</li>
                            <li><i class="fa fa-envelope"></i> gerardo@gmail.com</li>
                            <li><i class="fa fa-phone"></i> 9611930080</li>
                        </ul>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="innerAll strong">NO SE ENCONTRARON COINCIDENCIAS.</p>
@endif