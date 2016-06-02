<?php
namespace Sidep\Dominio\ServidoresPublicos;

use Sidep\Dominio\Personas\Persona;

/**
 * Class ServidoresPublicos
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 2.0
 */
class ServidorPublico extends Persona
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $curp;

    /**
     * @var string
     */
    private $rfc;

    public function __construct($nombre = '', $paterno = '', $materno = '', $rfc = '')
    {
        $this->rfc = $rfc;
        parent::__construct($nombre, $paterno, $materno);
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
    public function getCurp()
    {
        return $this->curp;
    }

    /**
     * @return string
     */
    public function getRfc()
    {
        return $this->rfc;
    }
}