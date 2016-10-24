<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

/**
 * Interface DeclaracionesRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface DeclaracionesRepositorio
{
    /**
     * obtener una lista de declaraciones
     * @param array $parametros
     * @return array|null
     */
    public function obtenerPor(array $parametros);

    /**
     * obtener una lista de años en los que se han realizado declaraciones
     * @return array
     */
    public function obtenerAniosDeclaracion();
}