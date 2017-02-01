<?php
namespace Sidep\Aplicacion\Modelos;

use Illuminate\Database\Eloquent\Model;
use Sidep\Aplicacion\Mes;

/**
 * Class DiaFestivoOficial
 * @package Sidep\Aplicacion\Modelos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DiaFestivoOficial extends Model
{
    /**
     * @var string
     */
    protected $table = 'dia_festivo_oficial';

    const CREATED_AT = 'fecha_alta';
    const UPDATED_AT = 'fecha_modificacion';

    /**
     * asignar la fecha al día festivo
     * @param int $dia
     * @param int $mes
     * @param string $celebracion
     */
    public function asignarFecha($dia, $mes, $celebracion)
    {
        $fecha = '';

        // asignar día
        $dia < 10 ? $fecha .= '0' . (string)$dia : $fecha .= (string)$dia;

        // asignar mes
        $mes < 10 ? $fecha .= '/0' . (string)$mes : $fecha .= '/' . (string)$mes;

        $this->fecha       = $fecha;
        $this->celebracion = $celebracion;
    }

    public function fecha()
    {
        list($dia, $mes) = explode('/', $this->fecha);

        return $dia . ' DE ' . Mes::nombreMes($mes);
    }
}