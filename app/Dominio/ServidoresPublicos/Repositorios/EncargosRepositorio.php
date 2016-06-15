<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

use Sidep\Dominio\ServidoresPublicos\Encargo;

/**
 * Interface EncargosRepositorio
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface EncargosRepositorio
{
    /**
     * @param string $username
     * @return Encargo
     */
    public function obtenerEncargoPorUsernameCuentaAcceso($username);

    /**
     * @param string $parametro
     * @return array|null
     */
    public function obtenerEncargos($parametro = '');

    /**
     * persistir el encargo generado
     * @param Encargo $encargo
     * @return bool
     */
    public function guardar(Encargo $encargo);
}