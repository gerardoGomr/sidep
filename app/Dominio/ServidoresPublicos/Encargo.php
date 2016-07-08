<?php
namespace Sidep\Dominio\ServidoresPublicos;

use Sidep\Dominio\Excepciones\NoEsMovimientoDeAltaException;
use Sidep\Dominio\Excepciones\NoEsDeclaracionInicialException;
use Sidep\Dominio\Listas\IColeccion;

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

    /**
     * @var string
     */
    private $fechaAlta;

    /**
     * @var bool
     */
    private $activo;

    /**
     * @var Dependencia
     */
    private $dependencia;

    /**
     * @var Coleccion
     */
    private $movimientos;

    /**
     * @var Coleccion
     */
    private $declaraciones;

    /**
     * @var bool
     */
    private $exento;

    /**
     * Encargo constructor.
     * @param ServidorPublico $servidorPublico
     * @param $adscripcion
     * @param CuentaAcceso|null $cuentaAcceso
     * @param Puesto|null $puesto
     * @param Dependencia $dependencia
     * @param null|IColeccion $declaraciones
     * @param null|IColeccion $movimientos
     */
    public function __construct(ServidorPublico $servidorPublico, $adscripcion, CuentaAcceso $cuentaAcceso = null, Puesto $puesto = null, Dependencia $dependencia, $declaraciones = null, IColeccion $movimientos = null)
    {
        $this->servidorPublico = $servidorPublico;
        $this->adscripcion     = $adscripcion;
        $this->cuentaAcceso    = $cuentaAcceso;
        $this->puesto          = $puesto;
        $this->movimientos     = $movimientos;
        $this->dependencia     = $dependencia;
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
     * @return string
     */
    public function getFechaAlta()
    {
        return $this->fechaAlta;
    }

    /**
     * @return boolean
     */
    public function estaActivo()
    {
        return $this->activo;
    }

    /**
     * @return string
     */
    public function getActivo()
    {
        if ($this->estaActivo()) {
            return 'ACTIVO';
        }

        return 'BAJA';
    }

    /**
     * @return boolean
     */
    public function estaExento()
    {
        return $this->exento;
    }

    public function getExento()
    {
        if ($this->estaExento()) {
            return 'EXENTO';
        }

        return '-';
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
     * @return Coleccion
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * @return Coleccion
     */
    public function getDeclaraciones()
    {
        return $this->declaraciones;
    }

    /**
     * @return Dependencia
     */
    public function getDependencia()
    {
        return $this->dependencia;
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

    /**
     * generar un movimiento de alta al encargo del servidor público
     *
     * se valida que el movimiento sea de tipo alta y que la declaración sea de tipo inicial y que el encargo
     * no se haya marcado como exento
     *
     * @param bool $exento
     * @param Movimiento $movimiento
     * @param Declaracion $declaracion
     * @param string $fechaAlta
     * @throws NoEsDeclaracionInicialException
     * @throws NoEsMovimientoDeAltaException
     */
    public function alta($exento, Movimiento $movimiento, Declaracion $declaracion, $fechaAlta)
    {
        // fecha de alta
        $this->fechaAlta = $fechaAlta;
        $this->exento    = $exento;
        $this->activo    = true;

        // generar cuenta de acceso
        $this->generarCuentaDeAcceso();

        // generar movimiento de alta
        if ($movimiento->getMovimientoTipo() !== MovimientoTipo::ALTA) {
            throw new NoEsMovimientoDeAltaException('SE ESPERABA UN MOVIMIENTO DE ALTA');
        }

        $movimiento->generarComentario();
        $this->movimientos->add($movimiento);

        // generar declaración inicial si no está marcado como exento
        if (!$this->exento) {
            if ($declaracion->getDeclaracionTipo() !== DeclaracionTipo::INICIAL) {
                throw new NoEsDeclaracionInicialException('SE ESPERABA UNA DECLARACIÓN INICIAL');
            }

            $declaracion->generarFechaDeCumplimiento(new \DateTime());
            $this->declaraciones->add($declaracion);
        }
    }

    /**
     * realizar el proceso de baja de encargo del servidor público
     *
     * se valida que el movimiento sea de tipo baja, que la declaración sea de tipo conclusión,
     * que el encargo no esté marcado como exento y que el motivo de movimiento sea por término de encargo
     *
     * @param Movimiento $movimiento
     * @param Declaracion $declaracion
     * @throws NoEsDeclaracionConclusionException
     * @throws NoEsMovimientoDeBajaException
     */
    public function baja(Movimiento $movimiento, Declaracion $declaracion)
    {
        $this->activo = false;

        // generar movimiento de baja
        if ($movimiento->getMovimientoTipo() !== MovimientoTipo::BAJA) {
            throw new NoEsMovimientoDeBajaException('SE ESPERABA UN MOVIMIENTO DE BAJA');
        }

        $movimiento->generarComentario();
        $this->movimientos->add($movimiento);

        // validar que no esté exento
        if (!$this->exento) {
            if ($declaracion->getDeclaracionTipo() !== DeclaracionTipo::CONCLUSION) {
                throw new NoEsDeclaracionConclusionException('SE ESPERABA UNA DECLARACIÓN DE CONCLUSIÓN');
            }

            // validar que el movmiento sea solo por término de encargo
            // si es reclusión, proceso (penal o admivo) o fallecimiento, no generará declaración
            if ($movimiento->getMovimientoMotivo() === MovimientoMotivo::TERMINO_ENCARGO) {
                $declaracion->generarFechaDeCumplimiento(new \DateTime());
                $this->declaraciones->add($declaracion);
            }
        }
    }
}