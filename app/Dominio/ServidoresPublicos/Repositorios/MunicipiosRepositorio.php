<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

/**
 * Interface MunicipiosRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface MunicipiosRepositorio
{
    /**
     * @return array
     */
    public function obtenerTodos();
}