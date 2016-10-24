<?php
namespace Sidep\Aplicacion;
use Sidep\Aplicacion\Reportes\AbstractReporteCrystalReports;

/**
 * Class Reporte
 * @package Sidep\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Reporte
{
    /**
     * @var AbstractReporteCrystalReports
     */
    protected $reporte;

    /**
     * Reporte constructor.
     * @param AbstractReporteCrystalReports $reporte
     */
    public function __construct($reporte)
    {
        $this->reporte = $reporte;
    }

    /**
     * @return AbstractReporteCrystalReports
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