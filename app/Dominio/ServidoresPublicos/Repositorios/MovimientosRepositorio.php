<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

/**
 * Interface MovimientosRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface MovimientosRepositorio
{
    /**
     * obtener una lista de movimientos
     * @param array $parametros
     * @return array
     */
    public function obtenerPor(array $parametros);
}