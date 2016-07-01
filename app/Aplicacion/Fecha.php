<?php
namespace Sidep\Aplicacion;

/**
 * Class Fecha
 * @package Sise\Servicios
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Fecha
{
    /**
     * dar formato a una fecha, obteniendo el nombre del mes
     * la fecha puede tener el separador por '/' o por '-'
     * @param string $fecha
     * @return string
     */
    public static function fechaDeHoy($fecha)
    {
        $fechaActual = explode('/', $fecha);

        if (count($fechaActual) > 1) {
            return $fechaActual[2] . ' DE ' . Mes::nombreMes($fechaActual[1]) . ' DE ' . $fechaActual[0];
        }

        $fechaActual = explode('-', $fecha);

        if (count($fechaActual) > 1) {
            return $fechaActual[2] . ' DE ' . Mes::nombreMes($fechaActual[1]) . ' DE ' . $fechaActual[0];
        }

        throw new \InvalidArgumentException("El formato del parámetro $fecha es inválido");
    }
}