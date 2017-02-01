<?php

namespace Sidep\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Sidep\Aplicacion\TransformadorMayusculas;

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    /**
     * transformar request a mayusculas
     * @param Request $request
     */
    protected function transformarMayusculas(Request $request)
    {
        $transformador = new TransformadorMayusculas();
        $transformador->transformar($request);
    }
}
