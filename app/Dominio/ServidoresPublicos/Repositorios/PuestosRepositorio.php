<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

/**
 * Interface PuestosRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface PuestosRepositorio
{
    /**
     * @return array
     */
    public function obtenerTodos();

    /**
     * @param int $id
     * @return Puesto
     */
    public function obtenerPorId($id);
}