<?php
namespace Sidep\Dominio\Reportes;

/**
 * Interface IReporte
 * @package Sidep\Dominio\Reportes
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface IReporte
{
    /**
     * @return bool
     */
    public function generar();

    /**
     * @return bool
     */
    public function existeEnRutaDestino();
}