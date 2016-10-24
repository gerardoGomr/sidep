<?php
namespace Sidep\Dominio\Folios;

/**
 * Class Folio
 * @package Sidep\Dominio\Folios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Folio
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $nomenclatura;

    /**
     * @var int
     */
    private $anio;

    /**
     * @var int
     */
    private $numero;

    /**
     * Folio constructor.
     */
    public function __construct()
    {
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
    public function getNomenclatura()
    {
        return $this->nomenclatura;
    }

    /**
     * @return int
     */
    public function getAnio()
    {
        return $this->anio;
    }

    /**
     * @return int
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @return string
     */
    public function folio()
    {
        $folio        = '';
        $numero       = '';
        $nomenclatura = '';
        $longitud     = strlen((string)$this->numero);
        $longitudBase = 4 - $longitud;

        for ($i = 1; $i <= $longitudBase; $i++) {
            $numero .= '0';
        }

        $numero .= $this->numero;

        switch ($this->nomenclatura) {
            case Nomenclatura::REQUERIMIENTO:
                $nomenclatura = 'CECCC/UEySP/REQUERIMIENTO';
                break;
        }

        $folio .= $nomenclatura . '/' . $numero . '/' . $this->anio;

        return $folio;
    }

    /**
     * actualizar al siguiente número
     */
    public function actualizar()
    {
        $this->numero++;
    }
}