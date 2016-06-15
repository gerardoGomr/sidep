<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

/**
 * Interface DependenciasRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface DependenciasRepositorio
{
    /**
     * @return array
     */
    public function obtenerTodos();

    /**
     * @param int $id
     * @return Dependencia
     */
    public function obtenerPorId($id);
}