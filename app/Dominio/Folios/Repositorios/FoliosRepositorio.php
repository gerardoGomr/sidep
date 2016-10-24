<?php
namespace Sidep\Dominio\Folios\Repositorios;

use Sidep\Dominio\Folios\Folio;
use Sidep\Dominio\Repositorios\Repositorio;

/**
 * Interface FoliosRepositorio
 * @package Sidep\Dominio\Folios\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface FoliosRepositorio extends Repositorio
{
    /**
     * @param int $anio
     * @return Folio
     */
    public function obtenerFolioParaRequerimiento($anio);

    /**
     * actualizar cambios
     * @return bool
     */
    public function actualizar();
}