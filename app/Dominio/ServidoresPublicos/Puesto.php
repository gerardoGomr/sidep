<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class Puesto
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Puesto
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $puesto;

    /**
     * Puesto constructor.
     * @param int $id
     * @param string $puesto
     */
    public function __construct($id = 0, $puesto = null)
    {
        $this->id     = $id;
        $this->puesto = $puesto;
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
    public function getPuesto()
    {
        return $this->puesto;
    }
}