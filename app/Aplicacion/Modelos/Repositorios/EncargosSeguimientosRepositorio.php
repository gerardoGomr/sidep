<?php
namespace Sidep\Aplicacion\Modelos\Repositorios;

use Sidep\Aplicacion\Modelos\EncargoSeguimiento;
use Sidep\Dominio\Repositorios\Repositorio;

/**
 * Interface EncargosSeguimientosRepositorio
 * @package Sidep\Aplicacion\Modelos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface EncargosSeguimientosRepositorio extends Repositorio
{
    /**
     * persistir cambios
     * @param EncargoSeguimiento $encargoSeguimiento
     * @return bool
     */
    public function persistir(EncargoSeguimiento $encargoSeguimiento);
}