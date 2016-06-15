<?php
namespace Sidep\Dominio\ServidoresPublicos;

use \DateTime;
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

    /**
     * @var DateTime
     */
    private $fechaNacimiento;

    /**
     * @var Domicilio
     */
    private $domicilio;

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

    /**
     * @param $curp
     * @param $fechaNacimiento
     * @param Domicilio $domicilio
     * @return void
     */
    public function registrar($curp, DateTime $fechaNacimiento, Domicilio $domicilio)
    {
        $this->curp            = $curp;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->domicilio       = $domicilio;
    }
}