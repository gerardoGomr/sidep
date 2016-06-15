<?php
namespace Sidep\Dominio\ServidoresPublicos;

use \DateTime;

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
     * @var DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $comentario;

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * Movimiento constructor.
     * @param int $movimientoTipo
     * @param DateTime $fecha
     * @param string $comentario
     * @param int $id
     */
    public function __construct($movimientoTipo = 0, DateTime $fecha = null, $comentario = '', $id = 0)
    {
        $this->id             = $id;
        $this->movimientoTipo = $movimientoTipo;
        $this->fecha          = $fecha;
        $this->comentario     = $comentario;
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
        return $this->fecha->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getComentario()
    {
        return $this->comentario;
    }

    /**
     * muestra la descripción del movimiento
     * @return void
     */
    public function generarComentario()
    {
        if ($this->movimientoTipo == MovimientoTipo::ALTA) {
            $this->comentario = 'Se generó una alta el día ' . $this->getFecha();
        } else {
            $this->comentario = 'Se generó una baja el día ' . $this->getFecha();
        }
    }
}