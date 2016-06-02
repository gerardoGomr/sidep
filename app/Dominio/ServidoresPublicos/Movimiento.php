<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class Movimiento
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Movimiento
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $movimientoTipo;

    /**
     * @var string
     */
    private $fecha;

    /**
     * Movimiento constructor.
     * @param int $movimientoTipo
     * @param int $id
     * @param string $fecha
     */
    public function __construct($movimientoTipo = 0, $id = 0, $fecha = null)
    {
        $this->id             = $id;
        $this->movimientoTipo = $movimientoTipo;
        $this->fecha          = $fecha;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getMovimientoTipo()
    {
        return $this->movimientoTipo;
    }

    /**
     * @return string
     */
    public function getFecha()
    {
        return $this->fecha;
    }
}