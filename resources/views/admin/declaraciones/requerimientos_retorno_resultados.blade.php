@if(count($declaraciones) > 0)
    <style>
        li.omiso:hover {
            cursor: pointer;
        }
    </style>
    <p class="innerAll">SE ENCONTRARON <span class="text-primary">{{ count($declaraciones) }}</span> RESULTADOS.</p>
    <ul class="list-group list-group-1 borders-none margin-none">
        @foreach($declaraciones as $declaracion)
            <li class="list-group-item animated fadeInUp omiso">
                <div class="media innerAll">
                    <div class="media-body">
                        <p class="strong servidorPublico" data-id="{{ base64_encode($declaracion->getId()) }}">{{ $declaracion->getEncargo()->getServidorPublico()->nombreCompleto() }}</p>
                        <ul class="list-unstyled">
                            <li class="curp"><i class="fa fa-dot-circle-o"></i> {{ $declaracion->getEncargo()->getServidorPublico()->getCurp() }}</li>
                            <li class="dependencia"><i class="fa fa-dot-circle-o"></i> {{ $declaracion->getEncargo()->getDependencia()->getDependencia() }}</li>
                            <li class="declaracionTipo"><i class="fa fa-dot-circle-o"></i> DECLARACIÓN {{ $declaracion->declaracionTipo() }}</li>
                        </ul>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p class="innerAll">NO EXISTEN COINCIDENCIAS.</p>
@endif