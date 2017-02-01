<?php
namespace Sidep\Dominio\ServidoresPublicos;

use DateTime;
use DateInterval;
use Sidep\Dominio\Excepciones\NoEsDeclaracionConclusionException;
use Sidep\Dominio\Excepciones\NoEsMovimientoDeAltaException;
use Sidep\Dominio\Excepciones\NoEsDeclaracionInicialException;
use Sidep\Dominio\Excepciones\NoEsMovimientoDeBajaException;
use Sidep\Dominio\Excepciones\NoEsMovimientoDeCambioAdscripciónException;
use Sidep\Dominio\Excepciones\NoEsMovimientoPorPromocionException;
use Sidep\Dominio\Listas\IColeccion;
use Sidep\Dominio\Usuarios\Modulo;
use Sidep\Dominio\Usuarios\UsuarioTipo;

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
     * @var bool
     */
    private $usuarioSidep;

    /**
     * @var int
     */
    private $tipoUsuario;

    /**
     * @var Dependencia
     */
    private $dependencia;

    /**
     * @var IColeccion
     */
    private $movimientos;

    /**
     * @var IColeccion
     */
    private $declaraciones;

    /**
     * @var IColeccion
     */
    private $privilegios;

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
    public function esUsuarioSidep()
    {
        return $this->usuarioSidep;
    }

    /**
     * @return string
     */
    public function tipoUsuario()
    {
        $tipoUsuario = '';

        switch ($this->tipoUsuario) {
            case UsuarioTipo::ADMINISTRADOR:
                $tipoUsuario = 'ADMINISTRADOR';
                break;

            case UsuarioTipo::JEFE:
                $tipoUsuario = 'JEFE DE UNIDAD';
                break;

            case UsuarioTipo::ANALISTA:
                $tipoUsuario = 'ANALISTA';
                break;
        }

        return $tipoUsuario;
    }

    /**
     * @return boolean
     */
    public function estaExento()
    {
        return $this->exento;
    }

    /**
     * @return string
     */
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
     * @return IColeccion
     */
    public function getMovimientos()
    {
        return $this->movimientos;
    }

    /**
     * @return IColeccion
     */
    public function getDeclaraciones()
    {
        return $this->declaraciones;
    }

    /**
     * @return IColeccion
     */
    public function getPrivilegios()
    {
        return $this->privilegios;
    }

    public function inicializarModulos(IColeccion $privilegios)
    {
        if (is_null($this->privilegios)) {
            $this->privilegios = $privilegios;
        }
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

            $declaracion->generarFechaDeCumplimiento();
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
            if ($movimiento->getMovimientoMotivo() === MovimientoMotivo::RENUNCIA_VOLUNTARIA) {
                $declaracion->generarFechaDeCumplimiento();
                $this->declaraciones->add($declaracion);
            }
        }
    }

    /**
     * verifica si el servidor público tiene un email
     * @return bool
     */
    public function tieneEmail()
    {
        return !is_null($this->servidorPublico->getEmail());
    }

    /**
     * asigna una nueva adscripción al encargo
     *
     * valida que la nueva adscripción no sea la misma
     *
     * @param string $nuevaAdscripcion
     * @param Movimiento $movimiento
     * @return bool
     * @throws NoEsMovimientoDeCambioAdscripciónException
     */
    public function cambiarAdscripcion($nuevaAdscripcion, Movimiento $movimiento)
    {
        if ($this->adscripcion === $nuevaAdscripcion) {
            return false;
        }

        $this->adscripcion = $nuevaAdscripcion;

        // generar movimiento de cambio de adscripción
        if ($movimiento->getMovimientoTipo() !== MovimientoTipo::CAMBIO_ADSCRIPCION) {
            throw new NoEsMovimientoDeCambioAdscripciónException('SE ESPERABA UN MOVIMIENTO DE CAMBIO DE ADSCRIPCIÓN.');
        }

        $movimiento->generarComentario();
        $this->movimientos->add($movimiento);

        return true;
    }

    /**
     * @param Puesto $puesto
     * @param string $adscripcion
     * @param Movimiento $movimientoBaja
     * @param Movimiento $movimientoAlta
     * @param Declaracion $conclusion
     * @param Declaracion $inicial
     * @return bool
     * @throws NoEsDeclaracionConclusionException
     * @throws NoEsDeclaracionInicialException
     * @throws NoEsMovimientoDeAltaException
     * @throws NoEsMovimientoDeBajaException
     * @throws NoEsMovimientoPorPromocionException
     */
    public function recibirPromocion(Puesto $puesto, $adscripcion, Movimiento $movimientoBaja, Movimiento $movimientoAlta, Declaracion $conclusion, Declaracion $inicial)
    {
        if ($this->puesto->getId() === $puesto->getId()) {
            throw new \InvalidArgumentException('EL PUESTO NO DEBE SER EL MISMO');
        }

        // validar los movimientos
        if ($movimientoBaja->getMovimientoTipo() !== MovimientoTipo::BAJA) {
            throw new NoEsMovimientoDeBajaException('SE ESPERABA UN MOVIMIENTO DE BAJA.');
        }

        if ($movimientoAlta->getMovimientoTipo() !== MovimientoTipo::ALTA) {
            throw new NoEsMovimientoDeAltaException('SE ESPERABA UN MOVIMIENTO DE ALTA.');
        }

        // validar los motivos para que sean de tipo promoción
        if ($movimientoBaja->getMovimientoMotivo() !== MovimientoMotivo::PROMOCION && $movimientoAlta !== MovimientoMotivo::PROMOCION) {
            throw new NoEsMovimientoPorPromocionException('SE ESPERABA QUE LOS MOTIVOS DE MOVIMIENTOS FUERAN DE TIPO PROMOCIÓN');
        }

        if (!$this->exento) {
            // validar las declaraciones
            if ($conclusion->getDeclaracionTipo() !== DeclaracionTipo::CONCLUSION) {
                throw new NoEsDeclaracionConclusionException('SE ESPERABA UNA DECLARACIÓN DE CONCLUSIÓN');
            }

            if ($inicial->getDeclaracionTipo() !== DeclaracionTipo::INICIAL) {
                throw new NoEsDeclaracionInicialException('SE ESPERABA UNA DECLARACIÓN INICIAL');
            }

            // fechas de cumplimiento
            $conclusion->generarFechaDeCumplimiento(); // a partir de la fecha de generación
            $inicial->generarFechaDeCumplimiento();

            $this->declaraciones->add($conclusion);
            $this->declaraciones->add($inicial);
        }

        $this->puesto      = $puesto;
        $this->adscripcion = $adscripcion;

        $movimientoBaja->generarComentario();
        $movimientoAlta->generarComentario();

        $this->movimientos->add($movimientoBaja);
        $this->movimientos->add($movimientoAlta);
    }

    /**
     * obtener la fecha de un día antes
     * @param  DateTime $fecha
     * @return DateTime
     */
    public function obtenerFechaAnteriorAPromocion(DateTime $fecha)
    {
        // nueva fecha con el mismo valor que la fecha enviada
        $nuevaFecha = DateTime::createFromFormat('d/m/Y', $fecha->format('d/m/Y'));
        return $nuevaFecha->sub(new DateInterval('P1D'))->format('d/m/Y');
    }

    /**
     * verifica si tiene movimientos generados
     * @return bool
     */
    public function tieneMovimientos()
    {
        return $this->movimientos->count() > 0;
    }

    /**
     * devuelve el ultimo movimiento realizado
     * @return Movimiento
     */
    public function obtenerUltimoMovimiento()
    {
        if ($this->tieneMovimientos()) {
            $movimiento = $this->movimientos->last();

            return $movimiento;
        }

        return null;
    }

    /**
     * verificar que el último movimiento es BAJA
     * @return bool
     */
    public function elUltimoMovimientoEsBaja()
    {
        return $this->obtenerUltimoMovimiento()->getMovimientoTipo() === MovimientoTipo::BAJA;
    }

    /**
     * verifica que el último movimiento es por renuncia voluntaria
     * @return bool
     */
    public function elUltimoMovimientoEsPorTerminoEncargo()
    {
        return $this->obtenerUltimoMovimiento()->getMovimientoMotivo() === MovimientoMotivo::RENUNCIA_VOLUNTARIA;
    }

    /**
     * generar usuario sidep
     * @param int $usuarioTipo
     */
    public function generarUsuarioSidep($usuarioTipo)
    {
        $this->usuarioSidep = true;
        $this->tipoUsuario  = $usuarioTipo;
    }

    /**
     * remover todos los elementos de la coleccion
     */
    public function removerPrivilegios()
    {
        $this->privilegios->clear();
    }

    /**
     * agregar un modulo a privilegios
     * @param EncargoPrivilegio $encargoPrivilegio
     */
    public function asignarPrivilegio(EncargoPrivilegio $encargoPrivilegio)
    {
        $this->privilegios->add($encargoPrivilegio);
    }

    /**
     * verifica que el módulo tenga asignado el privilegio
     * @param Modulo $modulo
     * @return bool
     */
    public function tieneElPrivilegio(Modulo $modulo)
    {
        foreach ($this->privilegios as $encargoModulo) {
            if ($encargoModulo->getModulo()->getId() === $modulo->getId()) {
                return true;
            }
        }

        return false;
    }

    /**
     * quita la bandera de usuario SIDEP
     */
    public function yaNoEsUsuarioSidep()
    {
        $this->usuarioSidep = false;
    }
}