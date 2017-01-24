<?php
namespace Sidep\Dominio\ServidoresPublicos;

use DateTime;
use Sidep\Dominio\Usuarios\Modulo;

/**
 * Class EncargoPrivilegio
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 2.0
 */
class EncargoPrivilegio
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var Modulo
     */
    private $modulo;

    /**
     * @var Encargo
     */
    private $encargoAsigna;

    /**
     * @var Encargo
     */
    private $encargo;

    /**
     * @var DateTime
     */
    private $fechaAsignacion;

    /**
     * EncargoPrivilegio constructor.
     * @param Modulo $modulo
     * @param Encargo $encargoAsigna
     * @param Encargo $encargo
     * @param DateTime $fechaAsignacion
     */
    public function __construct(Modulo $modulo, Encargo $encargoAsigna, Encargo $encargo, DateTime $fechaAsignacion)
    {
        $this->modulo          = $modulo;
        $this->encargoAsigna   = $encargoAsigna;
        $this->encargo         = $encargo;
        $this->fechaAsignacion = $fechaAsignacion;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Modulo
     */
    public function getModulo()
    {
        return $this->modulo;
    }

    /**
     * @return Encargo
     */
    public function getEncargoAsigna()
    {
        return $this->encargoAsigna;
    }

    /**
     * @return Encargo
     */
    public function getEncargo()
    {
        return $this->encargo;
    }

    /**
     * @return string
     */
    public function getFechaAsignacion()
    {
        return $this->fechaAsignacion->format('d/m/Y');
    }
}