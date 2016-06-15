<?php
namespace Sidep\Aplicacion;

use Illuminate\Http\Request;

/**
 * Class TransformadorMayusculas
 * @package Sidep\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class TransformadorMayusculas
{
    /**
     * transformar los valores del request a mayúsculas
     * @param Request $request
     * @return void
     */
    public function transformar(Request $request)
    {
        $input = $request->all();
        $request->merge(array_map('mb_strtoupper', $input));
    }
}