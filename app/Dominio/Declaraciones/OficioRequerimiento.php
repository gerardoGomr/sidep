<?php
namespace Sidep\Dominio\Declaraciones;

use DateTime;

/**
 * Class OficioRequerimiento
 * @package Sidep\Dominio\Declaraciones
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class OficioRequerimiento
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $folio;

    /**
     * @var DateTime
     */
    private $fecha;

    /**
     * OficioRequerimiento constructor.
     * @param string $folio
     * @param DateTime $fecha
     */
    public function __construct($folio, DateTime $fecha)
    {
        $this->folio  = $folio;
        $this->fecha  = $fecha;
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
    public function getFolio()
    {
        return $this->folio;
    }

    /**
     * @return DateTime
     */
    public function getFecha()
    {
        return $this->fecha->format('d/m/Y');
    }
}