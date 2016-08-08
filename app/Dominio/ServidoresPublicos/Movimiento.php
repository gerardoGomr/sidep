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
     * @var int
     */
    private $movimientoMotivo;

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
     * @param string $movimientoTipo
     * @param DateTime $fecha
     * @param Encargo $encargo
     * @param null $movimientoMotivo
     * @param string $comentario
     * @param int $id
     */
    public function __construct($movimientoTipo = MovimientoTipo::ALTA, DateTime $fecha = null, Encargo $encargo, $movimientoMotivo = null, $comentario = '', $id = 0)
    {
        $this->id               = $id;
        $this->movimientoTipo   = $movimientoTipo;
        $this->encargo          = $encargo;
        $this->fecha            = $fecha;
        $this->comentario       = $comentario;
        $this->movimientoMotivo = $movimientoMotivo;
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
    public function getMovimientoTipo()
    {
        return $this->movimientoTipo;
    }

    /**
     * @return int
     */
    public function getMovimientoMotivo()
    {
        return $this->movimientoMotivo;
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
        $motivo = '';

        if (!is_null($this->movimientoMotivo)) {
            switch ($this->movimientoMotivo) {
                case MovimientoMotivo::TERMINO_ENCARGO:
                    $motivo = ' POR TÉRMINO DE ENCARGO';
                    break;

                case MovimientoMotivo::FALLECIMIENTO:
                    $motivo = ' POR FALLECIMIENTO';
                    break;

                case MovimientoMotivo::PROCESO:
                    $motivo = ' POR PROCESO PENAL O ADMINISTRATIVO';
                    break;

                case MovimientoMotivo::RECLUSION:
                    $motivo = ' POR RECLUSIÓN';
                    break;

                case MovimientoMotivo::PROMOCION:
                    $motivo = ' POR PROMOCIÓN';
                    break;
            }
        }

        if ($this->movimientoTipo == MovimientoTipo::ALTA) {
            return 'ALTA' . $motivo;
        }

        if ($this->movimientoTipo == MovimientoTipo::BAJA) {
            return 'BAJA' . $motivo;
        }

        if ($this->movimientoTipo == MovimientoTipo::CAMBIO_ADSCRIPCION) {
            return 'CAMBIO DE ADSCRIPCIÓN';
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
        }

        if ($this->movimientoTipo == MovimientoTipo::BAJA) {
            $this->comentario = 'SE GENERÓ UNA BAJA EL DÍA ' . $this->getFecha();
        }
    }
}