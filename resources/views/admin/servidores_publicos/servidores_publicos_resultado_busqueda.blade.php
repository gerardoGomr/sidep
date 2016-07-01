@if(isset($encargos) && !is_null($encargos))
    <ul id="servidoresPublicos" class="list-group list-group-1 borders-none">
        @foreach($encargos as $encargo)
            <li class="list-group-item animated fadeInUp" data-id="{{ base64_encode($encargo->getId()) }}">
                <div class="media innerAll">
                    <div class="media-body innerT half">
                        <p class="strong margin-none padding-none text-primary">{{ $encargo->servidorPublico()->nombreCompleto() }}</p>
                        <ul class="text-small list-unstyled">
                            <li><i class="fa fa-building-o"></i> {{ !is_null($encargo->getDependencia()) ? $encargo->getDependencia()->getDependencia() : '' }}</li>
                            <li><i class="fa fa-envelope"></i> {{ strlen($encargo->servidorPublico()->getEmail()) > 0 ? $encargo->servidorPublico()->getEmail() : '-' }}</li>
                            <li><i class="fa fa-phone"></i> {{ strlen($encargo->servidorPublico()->getTelefono()) > 0 ? $encargo->servidorPublico()->getTelefono() : '-' }}</li>
                        </ul>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="innerAll strong">NO SE ENCONTRARON COINCIDENCIAS.</p>
@endif