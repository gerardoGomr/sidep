<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class DeclaracionEstatus
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class DeclaracionEstatus
{
    const PENDIENTE_EN_TIEMPO      = 1;
    const PENDIENTE_EXTEMPORANEA   = 2;
    const DECLARACION_EN_TIEMPO    = 3;
    const DECLARACION_EXTEMPORANEA = 4;
}