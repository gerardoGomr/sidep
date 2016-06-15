<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

/**
 * Interface ServidoresPublicoRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface ServidoresPublicosRepositorio
{
    /**
     * @param int $id
     * @return ServidorPublico
     */
    public function obtenerPorId($id);
}