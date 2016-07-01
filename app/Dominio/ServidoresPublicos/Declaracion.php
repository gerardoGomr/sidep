<?php
namespace Sidep\Dominio\ServidoresPublicos;

use DateTime;

/**
 * Class Declaracion
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Declaracion
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $declaracionTipo;

    /**
     * @var DateTime
     */
    private $fechaGeneracion;

    /**
     * @var DateTime
     */
    private $fechaPlazo;

    /**
     * @var bool
     */
    private $realizada;

    /**
     * @var string
     */
    private $observacion;

    /**
     * @var bool
     */
    private $tieneRequerimiento;

    /**
     * @var string
     */
    private $numeroRequerimiento;

    /**
     * @var DateTime
     */
    private $fechaGeneracionRequerimiento;

    /**
     * @var DateTime
     */
    private $fechaRecepcionRequerimiento;

    /**
     * @var DateTime
     */
    private $fechaPlazoCumplimiento;

    /**
     * @var bool
     */
    private $sancionada;

    /**
     * @var DateTime
     */
    private $fechaEnvioFuncionPublica;

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * Declaracion constructor.
     * @param int $tipo
     * @param DateTime $fecha
     * @param Encargo $encargo
     * @param int|null $id
     */
    public function __construct($tipo, DateTime $fecha, Encargo $encargo, $id = null)
    {
        $this->id              = $id;
        $this->declaracionTipo = $tipo;
        $this->fechaGeneracion = $fecha;
        $this->encargo         = $encargo;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getFechaGeneracion()
    {
        return $this->fechaGeneracion->format('d/m/Y');
    }

    /**
     * @return DateTime
     */
    public function getFechaPlazo()
    {
        return $this->fechaPlazo->format('d/m/Y');
    }

    /**
     * @return boolean
     */
    public function isRealizada()
    {
        return $this->realizada;
    }

    /**
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * @return boolean
     */
    public function isTieneRequerimiento()
    {
        return $this->tieneRequerimiento;
    }

    /**
     * @return string
     */
    public function getNumeroRequerimiento()
    {
        return $this->numeroRequerimiento;
    }

    /**
     * @return DateTime
     */
    public function getFechaGeneracionRequerimiento()
    {
        return $this->fechaGeneracionRequerimiento;
    }

    /**
     * @return DateTime
     */
    public function getFechaRecepcionRequerimiento()
    {
        return $this->fechaRecepcionRequerimiento;
    }

    /**
     * @return DateTime
     */
    public function getFechaPlazoCumplimiento()
    {
        return $this->fechaPlazoCumplimiento;
    }

    /**
     * @return boolean
     */
    public function isSancionada()
    {
        return $this->sancionada;
    }

    /**
     * @return DateTime
     */
    public function getFechaEnvioFuncionPublica()
    {
        return $this->fechaEnvioFuncionPublica;
    }

    /**
     * @return int
     */
    public function getDeclaracionTipo()
    {
        return $this->declaracionTipo;
    }

    /**
     * devuelve en cadena el tipo de declaración
     * @return string
     */
    public function declaracionTipo()
    {
        $tipo = '';
        switch ($this->declaracionTipo) {
            case DeclaracionTipo::INICIAL:
                $tipo = 'INICIAL';
                break;

            case DeclaracionTipo::MODIFICACION:
                $tipo = 'MODIFICACIÓN';
                break;

            case DeclaracionTipo::CONCLUSION:
                $tipo = 'CONCLUSIÓN';
                break;
        }

        return $tipo;
    }

    /**
     * @return Encargo
     */
    public function getEncargo()
    {
        return $this->encargo;
    }

    /**
     * calcula la fecha de cumplimiento de la declaracion en base al tipo
     * @param DateTime $fecha
     */
    public function generarFechaDeCumplimiento(DateTime $fecha)
    {
        $this->fechaPlazo = $fecha;

        switch ($this->declaracionTipo) {
            case DeclaracionTipo::INICIAL:
                // 60 días
                $dias = new \DateInterval('P60D');
                break;

            case DeclaracionTipo::MODIFICACION:
                // 31 días
                $dias = new \DateInterval('P31D');
                break;

            case DeclaracionTipo::CONCLUSION:
                // 30 días
                $dias = new \DateInterval('P30D');
                break;
        }

        $this->fechaPlazo->add($dias);
    }
}