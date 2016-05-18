<?php
namespace Sidep\Dominio\ServidoresPublicos;

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

    public function __construct()
    {
    }

    /**
     * obtener el nombre completo del funcionario
     * @return string
     */
    public function nombreCompleto()
    {
        // TODO: Implement nombreCompleto() method.
        $nombre = $this->nombre;

        if (strlen($this->paterno)) {
            $nombre .= ' ' . $this->paterno;
        }

        if (strlen($this->materno)) {
            $nombre .= ' ' . $this->materno;
        }

        return $nombre;
    }
}