<?php
namespace Sidep\Dominio\ServidoresPublicos;

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
     * @var string
     */
    private $fechaInicial;

    /**
     * @var string
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
     * @var
     */
    private $numeroRequerimiento;

    /**
     * @var string
     */
    private $fechaGeneracionRequerimiento;

    /**
     * @var string
     */
    private $fechaRecepcionRequerimiento;

    /**
     * @var string
     */
    private $fechaPlazoCumplimiento;

    /**
     * @var bool
     */
    private $sancionada;

    /**
     * @var string
     */
    private $fechaEnvioFuncionPublica;

    /**
     * Declaracion constructor.
     * @param int $tipo
     * @param int $id
     */
    public function __construct($tipo, $id = null)
    {
        $this->id = $id;
        $this->declaracionTipo = $tipo;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFechaInicial()
    {
        return $this->fechaInicial;
    }

    /**
     * @return string
     */
    public function getFechaPlazo()
    {
        return $this->fechaPlazo;
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
     * @return mixed
     */
    public function getNumeroRequerimiento()
    {
        return $this->numeroRequerimiento;
    }

    /**
     * @return string
     */
    public function getFechaGeneracionRequerimiento()
    {
        return $this->fechaGeneracionRequerimiento;
    }

    /**
     * @return string
     */
    public function getFechaRecepcionRequerimiento()
    {
        return $this->fechaRecepcionRequerimiento;
    }

    /**
     * @return string
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
     * @return string
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
}