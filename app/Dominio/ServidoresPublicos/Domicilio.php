<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class Domicilio
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Domicilio
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $calle;

    /**
     * @var string
     */
    private $noExterior;

    /**
     * @var string
     */
    private $noInterior;

    /**
     * @var string
     */
    private $localidadColonia;

    /**
     * @var string
     */
    private $municipio;

    /**
     * @var string
     */
    private $codigoPostal;

    /**
     * Domicilio constructor.
     * @param string|null $calle
     * @param string|null $noExterior
     * @param string|null $noInterior
     * @param string|null $localidadColonia
     * @param string|null $codigoPostal
     * @param string|null $municipio
     */
    public function __construct($calle = null, $noExterior = null, $noInterior = null, $localidadColonia = null, $codigoPostal = null, $municipio = null)
    {
        $this->calle            = $calle;
        $this->noExterior       = $noExterior;
        $this->noInterior       = $noInterior;
        $this->localidadColonia = $localidadColonia;
        $this->codigoPostal     = $codigoPostal;
        $this->municipio        = $municipio;
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
    public function getCalle()
    {
        return $this->calle;
    }

    /**
     * @return string
     */
    public function getNoExterior()
    {
        return $this->noExterior;
    }

    /**
     * @return string
     */
    public function getNoInterior()
    {
        return $this->noInterior;
    }

    /**
     * @return string
     */
    public function getLocalidadColonia()
    {
        return $this->localidadColonia;
    }

    /**
     * @return string
     */
    public function getCodigoPostal()
    {
        return $this->codigoPostal;
    }

    /**
     * @return string
     */
    public function getMunicipio()
    {
        return $this->municipio;
    }

    /**
     * retorna el domicilio completo del asociado protegido
     * @return null|string
     */
    public function direccionCompleta()
    {
        $direccion = $this->calle;

        if (strlen($this->noExterior)) {
            $direccion .= ' ' . $this->noExterior;
        }

        if (strlen($this->noInterior)) {
            $direccion .= ' ' . $this->noInterior;
        }

        if (strlen($this->localidadColonia)) {
            $direccion .= ' ' . $this->localidadColonia;
        }

        if (strlen($this->codigoPostal)) {
            $direccion .= ' C. P. ' . $this->codigoPostal;
        }

        if (strlen($this->municipio)) {
            $direccion .= ' ' . $this->municipio;
        }

        return $direccion;
    }
}