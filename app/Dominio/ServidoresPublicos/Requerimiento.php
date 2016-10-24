<?php
namespace Sidep\Dominio\ServidoresPublicos;

use DateInterval;
use DateTime;
use Sidep\Dominio\Declaraciones\OficioRequerimiento;
use Sidep\Dominio\Folios\Folio;

/**
 * Class Requerimiento
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Requerimiento
{
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
    private $requermientoRevisadoPorPatrimonial;

    /**
     * Requerimiento constructor.
     * @param Folio $folio
     * @param DateTime $fechaGeneracionRequerimiento
     */
    public function __construct(Folio $folio, DateTime $fechaGeneracionRequerimiento)
    {
        $this->numeroRequerimiento          = $folio->folio();
        $this->fechaGeneracionRequerimiento = $fechaGeneracionRequerimiento;
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
        return $this->fechaGeneracionRequerimiento->format('d/m/Y');
    }

    /**
     * @return DateTime
     */
    public function getFechaRecepcionRequerimiento()
    {
        return $this->fechaRecepcionRequerimiento->format('d/m/Y');
    }

    /**
     * @return DateTime
     */
    public function getFechaPlazoCumplimiento()
    {
        return $this->fechaPlazoCumplimiento->format('d/m/Y');
    }

    /**
     * @return boolean
     */
    public function requermientoRevisadoPorPatrimonial()
    {
        return $this->requermientoRevisadoPorPatrimonial;
    }

    /**
     * se marca el retorno de un requerimiento mediante un oficio.
     * se asigna también el nuevo plazo de cumplimiento, que será de 7 días
     * a partir del retorno
     * @param OficioRequerimiento $oficio
     */
    public function marcarRetornoDeRequerimiento(OficioRequerimiento $oficio)
    {
        $this->fechaPlazoCumplimiento = DateTime::createFromFormat('d/m/Y', $oficio->getFecha());
        $this->fechaPlazoCumplimiento->add(new DateInterval('P7D'));
    }

    /**
     * se desmarca de estatus omiso a esta declaración
     */
    public function desmarcarOmiso()
    {
        $this->fechaGeneracionRequerimiento = null;
    }

    /**
     * se desmarca el estatus de recepción de requerimiento
     */
    public function desmarcarRecepcionRequerimiento()
    {
        $this->fechaPlazoCumplimiento = null;
    }
}