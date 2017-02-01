<?php
namespace Sidep\Aplicacion\Modelos;

use Illuminate\Database\Eloquent\Model;
use Sidep\Aplicacion\Mes;

/**
 * Class DiaFestivoNoOficial
 * @package Sidep\Aplicacion\Modelos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class DiaFestivoNoOficial extends Model
{
    /**
     * @var string
     */
    protected $table = 'dia_festivo_no_oficial';

    const CREATED_AT = 'fecha_alta';
    const UPDATED_AT = 'fecha_modificacion';

    /**
     * asignar la fecha al día festivo
     * @param string $dia
     * @param string $celebracion
     */
    public function asignarFecha($dia, $celebracion)
    {

        $this->dia         = $dia;
        $this->celebracion = $celebracion;
    }
}