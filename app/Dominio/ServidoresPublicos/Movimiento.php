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
     * @var string
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
     * @param int|string $movimientoTipo
     * @param DateTime $fecha
     * @param Encargo $encargo
     * @param string $comentario
     * @param int $id
     */
    public function __construct($movimientoTipo = MovimientoTipo::ALTA, DateTime $fecha = null, Encargo $encargo, $comentario = '', $id = 0)
    {
        $this->id             = $id;
        $this->movimientoTipo = $movimientoTipo;
        $this->encargo        = $encargo;
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
     * @return string
     */
    public function movimientoTipo()
    {
        if ($this->movimientoTipo == MovimientoTipo::ALTA) {
            return 'ALTA';
        }

        if ($this->movimientoTipo == MovimientoTipo::BAJA) {
            return 'BAJA';
        }
    }

    /**
     * muestra la descripción del movimiento
     * @return void
     */
    public function generarComentario()
    {
        if ($this->movimientoTipo == MovimientoTipo::ALTA) {
            $this->comentario = 'SE GENERÓ UNA ALTA EL DÍA ' . $this->getFecha();
        } else {
            $this->comentario = 'SE GENERÓ UNA BAJA EL DÍA ' . $this->getFecha();
        }
    }
}