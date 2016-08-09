<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class MovimientoMotivo
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
abstract class MovimientoMotivo
{
	const RENUNCIA_VOLUNTARIA = 1;
	const FALLECIMIENTO       = 2;
	const PROCESO             = 3;
	const RECLUSION           = 4;
	const PROMOCION           = 5;
}