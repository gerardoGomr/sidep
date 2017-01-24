<?php
namespace Sidep\Dominio\Usuarios;
use Sidep\Dominio\Listas\IColeccion;

/**
 * Class Modulo
 * @package Sidep\Dominio\Usuarios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Modulo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $icono;

    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    private $nivel;

    /**
     * @var Modulo
     */
    private $moduloPadre;


    private $modulos;

    /**
     * Modulo constructor.
     * @param string $nombre
     * @param string $icono
     * @param string $url
     */
    public function __construct($nombre, $icono, $url)
    {
        $this->nombre = $nombre;
        $this->icono  = $icono;
        $this->url    = $url;
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @return string
     */
    public function getIcono()
    {
        return $this->icono;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return int
     */
    public function getNivel()
    {
        return $this->nivel;
    }

    /**
     * @return Modulo
     */
    public function getModuloPadre()
    {
        return $this->moduloPadre;
    }


    public function getModulos()
    {
        return $this->modulos;
    }

    /**
     * devuelve si tiene modulos
     * @return bool
     */
    public function tieneModulos()
    {
        return $this->modulos->count() > 0;
    }

    /**
     * devuelve si tiene un módulo padre
     * @return bool
     */
    public function tienePadre()
    {
        return !is_null($this->getModuloPadre());
    }

    /**
     * verifica si el módulo redirige o no
     * @return bool
     */
    public function tieneURL()
    {
        return !is_null($this->getUrl());
    }
}