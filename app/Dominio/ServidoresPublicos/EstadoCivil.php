<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class EstadoCivil
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class EstadoCivil
{
	const CASADO      = 1;
	const SOLTERO     = 2;
	const UNION_LIBRE = 3;
	const DIVORCIADO  = 4;
	const VIUDO       = 5;
}