<?php
namespace Sidep\Dominio\ServidoresPublicos;

use \DateTime;
use Sidep\Dominio\Excepciones\EstadoCivilInvalidoException;
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

    /**
     * @var int
     */
    private $estadoCivil;

    /**
     * Constructor
     * @param string $nombre
     * @param string $paterno
     * @param string $materno
     * @param string $rfc
     */
    public function __construct($nombre = '', $paterno = '', $materno = '', $rfc = '')
    {
        $this->rfc         = $rfc;
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
     * @return DateTime
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * @return Domicilio
     */
    public function getDomicilio()
    {
        return $this->domicilio;
    }

    /**
     * @return int
     */
    public function getEstadoCivil()
    {
        return $this->estadoCivil;
    }

    /**
     * @return string
     */
    public function estadoCivil()
    {
        $estadoCivil = '';

        switch ($this->estadoCivil) {
            case EstadoCivil::CASADO:
                $estadoCivil = 'CASADO';
                break;

            case EstadoCivil::SOLTERO:
                $estadoCivil = 'SOLTERO';
                break;

            case EstadoCivil::UNION_LIBRE:
                $estadoCivil = 'UNION LIBRE';
                break;

            case EstadoCivil::DIVORCIADO:
                $estadoCivil = 'DIVORCIADO';
                break;

            case EstadoCivil::VIUDO:
                $estadoCivil = 'VIUDO';
                break;
        }

        return $estadoCivil;
    }

    /**
     * actualizar datos del servidor público
     * @param  string $nombre
     * @param  string $paterno
     * @param  string $materno
     * @param  string $rfc
     * @param  string $curp
     * @param  DateTime $fechaNacimiento
     * @param  Domicilio $domicilio
     * @param int $estadoCivil
     * @param  string $telefono
     * @param  string $email
     * @throws EstadoCivilInvalidoException
     */
    public function registrar($nombre = '', $paterno = '', $materno = '', $rfc = '', $curp, DateTime $fechaNacimiento, Domicilio $domicilio, $estadoCivil = EstadoCivil::SOLTERO, $telefono = '', $email = '')
    {
        $this->curp            = $curp;
        $this->fechaNacimiento = $fechaNacimiento;
        $this->domicilio       = $domicilio;
        $this->rfc             = $rfc;
        $this->telefono        = $telefono;
        $this->email           = $email;
        $this->nombre          = $nombre;
        $this->paterno         = $paterno;
        $this->materno         = $materno;

        if ($estadoCivil != EstadoCivil::SOLTERO && $estadoCivil != EstadoCivil::CASADO && $estadoCivil != EstadoCivil::UNION_LIBRE && $estadoCivil != EstadoCivil::DIVORCIADO && $estadoCivil != EstadoCivil::VIUDO) {
            throw new EstadoCivilInvalidoException('EL ESTADO CIVIL ESPECIFICADO ES INVÁLIDO');
        }
        $this->estadoCivil = $estadoCivil;
    }
}