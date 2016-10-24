<?php
namespace Sidep\Dominio\ServidoresPublicos;

use DateTime;
use DateInterval;
use Sidep\Dominio\Declaraciones\OficioRequerimiento;
use Sidep\Dominio\Excepciones\YaTieneMarcadoElRetornoDeRequerimientoException;
use Sidep\Dominio\Folios\Folio;

/**
 * Class Declaracion
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Declaracion
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $declaracionTipo;

    /**
     * @var int
     */
    private $estatus;

    /**
     * @var DateTime
     */
    private $fechaGeneracion;

    /**
     * @var DateTime
     */
    private $fechaPlazo;

    /**
     * @var bool
     */
    private $realizada;

    /**
     * @var string
     */
    private $observacion;

    /**
     * @var bool
     */
    private $tieneRequerimiento;

    /**
     * @var Requerimiento
     */
    private $requerimiento;

    /**
     * @var bool
     */
    private $sancionada;

    /**
     * @var DateTime
     */
    private $fechaEnvioFuncionPublica;

    /**
     * @var string
     */
    private $numeroOficioSancion;

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * @var OficioRequerimiento
     */
    private $oficioRequerimiento;

    /**
     * @var bool
     */
    private $requerimientoAbierto;

    /**
     * Declaracion constructor.
     *
     * por default se le asigna el estatus de pendiente en tiempo
     *
     * @param int $tipo
     * @param DateTime $fecha
     * @param Encargo $encargo
     * @param int|null $id
     */
    public function __construct($tipo, DateTime $fecha, Encargo $encargo, $id = null)
    {
        $this->id              = $id;
        $this->declaracionTipo = $tipo;
        $this->fechaGeneracion = $fecha;
        $this->encargo         = $encargo;
        $this->estatus         = DeclaracionEstatus::PENDIENTE_EN_TIEMPO;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getFechaGeneracion()
    {
        return $this->fechaGeneracion->format('d/m/Y');
    }

    /**
     * evalua el estatus actual
     * @return string
     */
    public function estatus()
    {
        $estatus = '';
        switch ($this->estatus) {
            case DeclaracionEstatus::PENDIENTE_EN_TIEMPO:
                $estatus = 'PENDIENTE EN TIEMPO';
                break;

            case DeclaracionEstatus::PENDIENTE_EXTEMPORANEA:
                $estatus = 'PENDIENTE EXTEMPORANEA';
                break;

            case DeclaracionEstatus::DECLARACION_EN_TIEMPO:
                $estatus = 'DECLARACIÓN EN TIEMPO';
                break;

            case DeclaracionEstatus::DECLARACION_EXTEMPORANEA:
                $estatus = 'DECLARACIÓN EXTEMPORANEA';
                break;
        }

        return $estatus;
    }

    /**
     * @return DateTime
     */
    public function getFechaPlazo()
    {
        return $this->fechaPlazo->format('d/m/Y');
    }

    /**
     * @return boolean
     */
    public function realizada()
    {
        return $this->realizada;
    }

    /**
     * @return string
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * @return boolean
     */
    public function tieneRequerimiento()
    {
        return $this->tieneRequerimiento;
        //return is_null($this->requerimiento);
    }

    /**
     * @return Requerimiento
     */
    public function getRequerimiento()
    {
        return $this->requerimiento;
    }

    /**
     * @return boolean
     */
    public function sancionada()
    {
        return $this->sancionada;
    }

    /**
     * @return DateTime
     */
    public function getFechaEnvioFuncionPublica()
    {
        return $this->fechaEnvioFuncionPublica->format('d/m/Y');
    }

    /**
     * @return int
     */
    public function getDeclaracionTipo()
    {
        return $this->declaracionTipo;
    }

    /**
     * devuelve en cadena el tipo de declaración
     * @return string
     */
    public function declaracionTipo()
    {
        $tipo = '';
        switch ($this->declaracionTipo) {
            case DeclaracionTipo::INICIAL:
                $tipo = 'INICIAL';
                break;

            case DeclaracionTipo::MODIFICACION:
                $tipo = 'MODIFICACIÓN';
                break;

            case DeclaracionTipo::CONCLUSION:
                $tipo = 'CONCLUSIÓN';
                break;
        }

        return $tipo;
    }

    /**
     * @return Encargo
     */
    public function getEncargo()
    {
        return $this->encargo;
    }

    /**
     * @return OficioRequerimiento
     */
    public function getOficioRequerimiento()
    {
        return $this->oficioRequerimiento;
    }

    /**
     * calcula la fecha de cumplimiento de la declaracion en base al tipo
     */
    public function generarFechaDeCumplimiento()
    {
        $this->fechaPlazo = DateTime::createFromFormat('d/m/Y', $this->fechaGeneracion->format('d/m/Y'));

        switch ($this->declaracionTipo) {
            case DeclaracionTipo::INICIAL:
                // 60 días
                $dias = new DateInterval('P60D');
                break;

            case DeclaracionTipo::MODIFICACION:
                // 31 días
                $dias = new DateInterval('P31D');
                break;

            case DeclaracionTipo::CONCLUSION:
                // 30 días
                $dias = new DateInterval('P30D');
                break;
        }

        $this->fechaPlazo->add($dias);
    }

    /**
     * se marca a la declaración actual como omiso - tiene requerimiento y fecha
     * se actualiza el folio ocupado
     * @param DateTime $fecha
     * @param Folio $folio
     */
    public function marcarComoOmiso(DateTime $fecha, Folio $folio)
    {
        $this->tieneRequerimiento   = true;
        $this->requerimientoAbierto = false;
        $this->requerimiento        = new Requerimiento($folio, $fecha);

        $folio->actualizar();
    }

    /**
     * se marca el retorno de un requerimiento mediante un oficio.
     * se asigna también el nuevo plazo de cumplimiento, que será de 7 días
     * a partir del retorno
     * @param OficioRequerimiento $oficio
     */
    public function marcarRetornoDeRequerimiento(OficioRequerimiento $oficio)
    {
        $this->oficioRequerimiento = $oficio;
        $this->requerimiento->marcarRetornoDeRequerimiento($oficio);
    }

    /**
     * se desmarca de estatus omiso a esta declaración
     * @throws YaTieneMarcadoElRetornoDeRequerimientoException
     */
    public function desmarcarOmiso()
    {
        if ($this->seHaRegresadoElRequerimiento()) {
            throw new YaTieneMarcadoElRetornoDeRequerimientoException('NO SE PUEDE DESMARCAR A ESTA DECLARACIÓN COMO OMISO PORQUE YA SE MARCÓ EL RETORNO DEL REQUERIMIENTO.');
        }

        $this->tieneRequerimiento   = false;
        $this->requerimientoAbierto = null;
        $this->requerimiento->desmarcarOmiso();
    }

    /**
     * verifica si existe
     * @return bool
     */
    public function seHaRegresadoElRequerimiento()
    {
        return !is_null($this->oficioRequerimiento);
    }

    /**
     * se desmarca el estatus de recepción de requerimiento
     */
    public function desmarcarRecepcionRequerimiento()
    {
        $this->oficioRequerimiento = null;
        $this->requerimiento->desmarcarRecepcionRequerimiento();
    }

    /**
     * @return boolean
     */
    public function requerimientoAbierto()
    {
        return $this->requerimientoAbierto;
    }

    /**
     * marcar que ya se abrio el pdf cuando el usuario le da click
     */
    public function seAbrioElRequerimiento()
    {
        if(!$this->requerimientoAbierto) {
            $this->requerimientoAbierto = true;
        }
    }

    /**
     * se marca la declaración como sancionada
     * @param DateTime $fecha
     * @param Folio $folio
     */
    public function marcarEnvioASFP(DateTime $fecha, Folio $folio)
    {
        $this->sancionada               = true;
        $this->fechaEnvioFuncionPublica = $fecha;
        $this->numeroOficioSancion      = $folio->folio();

        $folio->actualizar();
    }

    /**
     * remover la sanción de la declaración
     */
    public function removerSancion()
    {
        $this->sancionada               = false;
        $this->fechaEnvioFuncionPublica = null;
    }
}