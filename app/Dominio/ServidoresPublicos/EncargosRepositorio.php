<?php
namespace Sidep\Dominio\ServidoresPublicos;

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
}