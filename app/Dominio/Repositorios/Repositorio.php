<?php
namespace Sidep\Dominio\Repositorios;
use Sidep\Dominio\Listas\IColeccion;

/**
 * Interface Repositorio
 * @package Sidep\Dominio\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface Repositorio
{
    /**
     * @return IColeccion
     */
    public function obtenerTodos();

    /**
     * @param int $id
     * @return mixed
     */
    public function obtenerPorId($id);
}