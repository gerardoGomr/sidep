<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

use Sidep\Dominio\Repositorios\Repositorio;
use Sidep\Dominio\ServidoresPublicos\Encargo;

/**
 * Interface EncargosRepositorio
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface EncargosRepositorio extends Repositorio
{
    /**
     * obtener un encargo
     * @param string $username
     * @return Encargo
     */
    public function obtenerEncargoPorUsernameCuentaAcceso($username);

    /**
     * obtener una lista de encargos
     * @param string $parametro
     * @return array|null
     */
    public function obtenerEncargos($parametro = '');

    /**
     * verificar que el encargo exista
     * @param int $id
     * @return bool
     */
    public function existeEncargo($id);

    /**
     * persistir el encargo generado
     * @param Encargo $encargo
     * @return bool
     */
    public function guardar(Encargo $encargo);
}