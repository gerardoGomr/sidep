<?php

namespace Sidep\Http\Controllers\Admin\Reportes;

use Illuminate\Http\Request;

use Sidep\Dominio\ServidoresPublicos\Repositorios\DeclaracionesRepositorio;
use Sidep\Http\Requests;
use Sidep\Http\Controllers\Controller;

/**
 * Class ReportesController
 * @package Sidep\Http\Controllers\Admin\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ReportesController extends Controller
{
    /**
     * generar la vista del reporte de modificación
     * @param DeclaracionesRepositorio $declaracionesRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reporteModificacion(DeclaracionesRepositorio $declaracionesRepositorio)
    {
        $anios = $declaracionesRepositorio->obtenerAniosDeclaracion();
        return view('admin.reportes.reporte_modificacion', compact('anios'));
    }
}
