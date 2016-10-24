<?php
namespace Sidep\Aplicacion\Reportes;

use COM;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sidep\Dominio\Excepciones\NoSePudoGenerarElReporteCrystalException;
use Sidep\Dominio\Reportes\IReporte;
use Sidep\Exceptions\SidepLogger;

/**
 * Class AbstractReporteCrystalReports
 * @package Sidep\Aplicacion\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class AbstractReporteCrystalReports implements IReporte
{
    /**
     * @var string
     */
    protected $rutaReporte;

    /**
     * @var string
     */
    protected $rutaPdf;

    /**
     * @var mixed
     */
    protected $reporte;

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
     * @return mixed
     */
    public function getReporte()
    {
        return $this->reporte;
    }

    /**
     * @return bool
     * @throws NoSePudoGenerarElReporteCrystalException
     */
    public function generar()
    {
        // TODO: Implement generar() method.
        try
        {
            $objectFactory = new COM("CrystalReports.ObjectFactory");
            // Creo una instancia del Componente de Diseñador de Crystal Reports
            $crystalApplication = $objectFactory->CreateObject('CrystalRuntime.Application');
            $this->reporte      = $crystalApplication->OpenReport($this->rutaReporte, 1);

            // DB Connection
            $this->reporte->Database->Tables(1)->SetLogOnInfo(config('database.connections.sqlsrv.host'), config('database.connections.sqlsrv.database'), config('database.connections.sqlsrv.username'), config('database.connections.sqlsrv.password'));

            //Con Enable Parameter Promting evito que lanze el formulario de captura de parametros ya que el browser del usuario no puede interactuar con el escritorio o el componente que crea el formulario.
            $this->reporte->EnableParameterPrompting = 0;

            //limpiar caché
            $this->reporte->DiscardSavedData;
            $this->reporte->ReadRecords();

            return true;

        } catch (NoSePudoGenerarElReporteCrystalException $e) {
            $logger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/exceptions/exc_' . date('Y-m-d') . '.log', Logger::ERROR));
            $logger->log($e);
            return false;
        }
    }

    /**
     * genera PDF despues de generar y leer el reporte
     */
    protected function aPDF()
    {
        $this->reporte->ExportOptions->DiskFileName      = $this->rutaPdf;
        $this->reporte->ExportOptions->PDFExportAllPages = true;
        $this->reporte->ExportOptions->DestinationType   = 1;
        $this->reporte->ExportOptions->FormatType        = 31;

        // Exporto el reporte
        $this->reporte->Export(false);
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