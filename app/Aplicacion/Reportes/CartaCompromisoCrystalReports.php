<?php
namespace Sidep\Aplicacion\Reportes;

/**
 * Class CartaCompromisoCrystalReports
 * @package Sidep\Aplicacion\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class CartaCompromisoCrystalReports extends AbstractReporteCrystalReports
{
    /**
     * @var int
     */
    protected $id;

    /**
     * CartaCompromisoCrystalReports constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id          = $id;
        $this->rutaReporte = "C:\\Apache24x86\\htdocs\\sidep\\resources\\reports\\carta_compromiso.rpt";
        $this->rutaPdf     = "C:\\Apache24x86\\htdocs\\sidep\\storage\\app\\public\\reports\\cartas_compromisos\\encargo_" . $this->id . '.pdf';
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
        $param->Item(1)->AddCurrentValue($this->id);

        $this->aPDF();

        return true;
    }
}