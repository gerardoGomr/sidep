<?php
namespace Sidep\Aplicacion;

/**
 * Class Reporte
 * @package Sidep\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Reporte
{
    /**
     * @var IReporte
     */
    protected $reporte;

    /**
     * Reporte constructor.
     * @param IReporte $reporte
     */
    public function __construct($reporte)
    {
        $this->reporte = $reporte;
    }

    /**
     * @return IReporte
     */
    public function getReporte()
    {
        return $this->reporte;
    }

    /**
     * generar el reporte
     * @return bool
     */
    public function generar()
    {
        return $this->reporte->generar();
    }

    /**
     * @return string
     */
    public function ruta()
    {
        return $this->reporte->getRutaPdf();
    }

    /**
     * @return bool
     */
    public function existe()
    {
        return $this->reporte->existeEnRutaDestino();
    }
}