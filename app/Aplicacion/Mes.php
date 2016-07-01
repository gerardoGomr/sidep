<?php
namespace Sidep\Aplicacion;

/**
 * Class Mes
 * @package Sise\Servicios
 * @author  Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Mes
{
    /**
     * @var array
     */
    private static $meses = [
        '01' => 'ENERO',
        '02' => 'FEBRERO',
        '03' => 'MARZO',
        '04' => 'ABRIL',
        '05' => 'MAYO',
        '06' => 'JUNIO',
        '07' => 'JULIO',
        '08' => 'AGOSTO',
        '09' => 'SEPTIEMBRE',
        '10' => 'OCTUBRE',
        '11' => 'NOVIEMBRE',
        '12' => 'DICIEMBRE'
    ];

    /**
     * @param string $numero
     * @return string
     */
    public static function nombreMes($numero)
    {
        return self::$meses[$numero];
    }
}