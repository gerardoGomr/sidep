<?php
namespace Sidep\Aplicacion\Reportes;

/**
 * Class ComprobanteCuentaAccesoCrystalReports
 * @package Sidep\Aplicacion\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ComprobanteCuentaAccesoCrystalReports extends AbstractReporteCrystalReports
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $primerPassword;

    /**
     * CartaCompromisoCrystalReports constructor.
     * @param int $id
     * @param string $primerPassword
     */
    public function __construct($id, $primerPassword)
    {
        $this->id             = $id;
        $this->primerPassword = $primerPassword;
        $this->rutaReporte    = "C:\\Apache24x86\\htdocs\\sidep\\resources\\reports\\comprobante_cuenta_acceso.rpt";
        $this->rutaPdf        = "C:\\Apache24x86\\htdocs\\sidep\\storage\\app\\public\\reports\\comprobantes_cuentas\\encargo_" . $this->id . '.pdf';
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
        $param->Item(2)->AddCurrentValue($this->primerPassword);

        $this->aPDF();

        return true;
    }
}