<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class Dependencia
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Dependencia
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $dependencia;

    /**
     * @var string
     */
    private $clave;

    /**
     * Dependencia constructor.
     * @param int $id
     * @param string $dependencia
     * @param null $clave
     */
    public function __construct($id = 0, $dependencia = null, $clave = null)
    {
        $this->id          = $id;
        $this->dependencia = $dependencia;
        $this->clave       = $clave;
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
    public function getDependencia()
    {
        return $this->dependencia;
    }

    /**
     * @return string
     */
    public function getClave()
    {
        return $this->clave;
    }
}