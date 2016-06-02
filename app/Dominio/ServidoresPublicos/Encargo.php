<?php
namespace Sidep\Dominio\ServidoresPublicos;

use Sidep\Dominio\Excepciones\NoEsMovimientoDeAltaException;
use Sidep\Dominio\Excepciones\NoEsDeclaracionInicialException;
use Sidep\Dominio\Listas\Coleccion;


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

    private $movimientos;

    private $declaraciones;

    public function __construct($servidorPublico, $adscripcion, $cuentaAcceso = null, $puesto = null, Coleccion $declaraciones = null)
    {
        $this->servidorPublico = $servidorPublico;
        $this->adscripcion     = $adscripcion;
        $this->cuentaAcceso    = $cuentaAcceso;
        $this->puesto          = $puesto;
        $this->movimientos     = new \SplObjectStorage();
        $this->declaraciones   = $declaraciones;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return ServidorPublico
     */
    public function getServidorPublico()
    {
        return $this->servidorPublico;
    }

    /**
     * @return string
     */
    public function getAdscripcion()
    {
        return $this->adscripcion;
    }

    /**
     * @return CuentaAcceso
     */
    public function getCuentaAcceso()
    {
        return $this->cuentaAcceso;
    }

    /**
     * @return Puesto
     */
    public function getPuesto()
    {
        return $this->puesto;
    }

    /**
     * @param string $password
     * @return bool
     */
    public function login($password)
    {
        return $this->cuentaAcceso->login($password);
    }

    /**
     * @return ServidorPublico
     */
    public function servidorPublico()
    {
        return $this->servidorPublico;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * @return \SplObjectStorage
     */
    public function getDeclaraciones()
    {
        return $this->declaraciones;
    }

    /**
     * generar cuenta de acceso del encargo del servidor público
     */
    public function generarCuentaDeAcceso()
    {
        $this->cuentaAcceso->generarCuentaDeAcceso($this->servidorPublico()->getRfc());
    }

    /**
     * comprobar que el encargo tiene una cuenta de acceso generada.
     * @return bool
     */
    public function tieneCuentaDeAccesoGenerada()
    {
        if (!is_null($this->cuentaAcceso) && !is_null($this->cuentaAcceso)) {
            return true;
        }

        return false;
    }

    public function alta($exento, Movimiento $movimiento, Declaracion $declaracion)
    {
        // generar cuenta de acceso
        $this->generarCuentaDeAcceso();

        // generar movimiento de alta
        if ($movimiento->getMovimientoTipo() !== MovimientoTipo::ALTA) {
            throw new NoEsMovimientoDeAltaException('Se esperaba un movimiento de alta');
        }
        $this->movimientos->attach($movimiento);
        // $this->movimientos->push(new Movimiento(MovimientoTipo::ALTA))
        // generar declaración inicial si no está marcado como exento
        if ($exento === false) {
            if ($declaracion->getDeclaracionTipo() !== DeclaracionTipo::INICIAL) {
                throw new NoEsDeclaracionInicialException('Se esperaba una declaración inicial');
            }
            $this->declaraciones->agregar($declaracion);
        }
    }

    public function baja()
    {
        // generar movimiento de baja

        // generar declaración de conclusión
    }
}