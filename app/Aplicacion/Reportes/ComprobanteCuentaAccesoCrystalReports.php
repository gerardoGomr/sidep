<?php
namespace Sidep\Aplicacion\Reportes;

use Sidep\Dominio\Reportes\IReporte;

/**
 * Class ComprobanteCuentaAccesoCrystalReports
 * @package Sidep\Aplicacion\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ComprobanteCuentaAccesoCrystalReports implements IReporte
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
     * @var string
     */
    protected $rutaReporte;

    /**
     * @var string
     */
    protected $rutaPdf;

    /**
     * CartaCompromisoCrystalReports constructor.
     * @param int $id
     * @param string $primerPassword
     */
    public function __construct($id, $primerPassword)
    {
        $this->id             = $id;
        $this->primerPassword = $primerPassword;
        //$this->rutaReporte = resource_path() . '/reports/carta_compromiso.rpt';
        $this->rutaReporte = "C:\\Apache24\\htdocs\\sidep\\resources\\reports\\comprobante_cuenta_acceso.rpt";
        $this->rutaPdf     = "C:\\Apache24\\htdocs\\sidep\\storage\\app\\public\\reports\\comprobantes_cuentas\\encargo_" . $this->id . '.pdf';
    }

    /**
     * @return string
     */
    public function getRutaReporte()
    {
        return $this->rutaReporte;
    }

    /**
     * @return string
     */
    public function getRutaPdf()
    {
        return $this->rutaPdf;
    }

    /**
     * generar el reporte estipulado
     * y guardarlo en la carpeta storage
     * @return bool
     */
    public function generar()
    {
        // TODO: Implement generar() method.
        try
        {
            $ObjectFactory = new \COM("CrystalReports.ObjectFactory");
            // Creo una instancia del Componente de Diseñador de Crystal Reports
            try
            {
                $crapp = $ObjectFactory->CreateObject("CrystalDesignRuntime.Application");
                // Mando abrir mi reporte
                $creport = $crapp->OpenReport($this->rutaReporte, 1);
            }
            catch(\Exception $e)
            {
                echo $e->getMessage()."<br />";
                print_r($e->getTrace());
            }

            // DB Connection
            $creport->Database->Tables(1)->SetLogOnInfo(config('database.connections.sqlsrv.host'), config('database.connections.sqlsrv.database'), config('database.connections.sqlsrv.username'), config('database.connections.sqlsrv.password'));

            //Con Enable Parameter Promting evito que lanze el formulario de captura de parametros ya que el browser del usuario no puede interactuar con el escritorio o el componente que crea el formulario.
            $creport->EnableParameterPrompting = 0;

            //limpiar caché
            $creport->DiscardSavedData;
            // $creport->ReadRecords();

            //obetener la lista de parámetros necesarios para la apertura del cristal report
            $param = $creport->ParameterFields;

            //asignación de valores para los parámetros:
            $param->Item(1)->AddCurrentValue($this->id);
            $param->Item(2)->AddCurrentValue($this->primerPassword);

            //opciones de exportación
            $creport->ExportOptions->DiskFileName      = $this->rutaPdf;
            $creport->ExportOptions->PDFExportAllPages = true;
            $creport->ExportOptions->DestinationType   = 1;
            $creport->ExportOptions->FormatType        = 31;

            // Exporto el reporte
            $creport->Export(false);

            return true;
        }
        catch (\Exception $e)
        {
            echo $e->getMessage()."<br />";
            print_r($e->getTrace());

            return false;
        }
    }

    /**
     * verifica que el reporte a generar ya exista en el directorio destino
     * @return bool
     */
    public function existeEnRutaDestino()
    {
        // TODO: Implement existeEnRutaDestino() method.
        if (file_exists($this->rutaPdf)) {
            return true;
        }

        return false;
    }
}