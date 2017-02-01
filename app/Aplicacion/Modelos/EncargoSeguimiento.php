<?php
namespace Sidep\Aplicacion\Modelos;

use DateTime;
use Sidep\Dominio\ServidoresPublicos\Encargo;

/**
 * Class EncargoSeguimiento
 * @package Sidep\Aplicacion\Modelos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class EncargoSeguimiento
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $accion;

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * EncargoSeguimiento constructor.
     * @param Encargo $encargo
     * @param DateTime $fecha
     * @param string $accion
     */
    public function __construct(Encargo $encargo, DateTime $fecha, $accion)
    {
        $this->encargo = $encargo;
        $this->fecha   = $fecha;
        $this->accion  = $accion;
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
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @return string
     */
    public function getAccion()
    {
        return $this->accion;
    }

    /**
     * @return Encargo
     */
    public function getEncargo()
    {
        return $this->encargo;
    }
}