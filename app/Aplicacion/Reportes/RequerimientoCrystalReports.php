<?php
namespace Sidep\Aplicacion\Reportes;

use Sidep\Dominio\ServidoresPublicos\Declaracion;

/**
 * Class RequerimientoCrystalReports
 * @package Sidep\Aplicacion\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class RequerimientoCrystalReports extends AbstractReporteCrystalReports
{
    /**
     * @var Declaracion
     */
    protected $declaracion;

    /**
     * RequerimientoCrystalReports constructor.
     * @param Declaracion $declaracion
     */
    public function __construct(Declaracion $declaracion)
    {
        $this->declaracion = $declaracion;
        $this->rutaReporte = "C:\\Apache24x86\\htdocs\\sidep\\resources\\reports\\requerimiento.rpt";
        $this->rutaPdf     = "C:\\Apache24x86\\htdocs\\sidep\\storage\\app\\public\\reports\\requerimientos\\declaracion_" . $this->declaracion->getId() . '.pdf';
    }

    /**
     * generar el reporte estipulado
     * y guardarlo en la carpeta storage
     * @return bool
     */
    public function generar()
    {
        if (!parent::generar()) {
            return false;
        }

        $param = $this->reporte->ParameterFields;

        //asignación de valores para los parámetros:
        $param->Item(1)->AddCurrentValue($this->declaracion->getEncargo()->getId());
        $param->Item(2)->AddCurrentValue($this->declaracion->getId());

        $this->aPDF();

        return true;
    }
}