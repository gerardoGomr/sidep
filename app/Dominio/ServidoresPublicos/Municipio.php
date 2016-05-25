<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class Municipio
 * municipio donde vive el funcionario público
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version
 */
class Municipio
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $municipio;

    /**
     * Municipio constructor.
     * @param int $id
     * @param string $municipio
     */
    public function __construct($id = 0, $municipio = null)
    {
        $this->id        = $id;
        $this->municipio = $municipio;
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
    public function getMunicipio()
    {
        return $this->municipio;
    }
}