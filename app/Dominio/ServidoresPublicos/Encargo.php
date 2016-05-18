<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class Encargo
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 2.0
 */
class Encargo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var ServidorPublico
     */
    private $servidorPublico;

    /**
     * @var string
     */
    private $adscripcion;

    /**
     * @var CuentaAcceso
     */
    private $cuentaAcceso;

    /**
     * @var Puesto
     */
    private $puesto;

    public function __construct($servidorPublico, $adscripcion, $cuentaAcceso, $puesto)
    {
    }

    /**
     * @param string $password
     * @return bool
     */
    public function login($password)
    {
        return $this->cuentaAcceso->login($password);
    }

    public function servidorPublico()
    {
        return $this->servidorPublico;
    }
}