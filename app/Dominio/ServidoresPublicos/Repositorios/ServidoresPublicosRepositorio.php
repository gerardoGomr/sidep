<?php
namespace Sidep\Dominio\ServidoresPublicos\Repositorios;

use Sidep\Dominio\Repositorios\Repositorio;
use Sidep\Dominio\ServidoresPublicos\ServidorPublico;

/**
 * Interface ServidoresPublicoRepositorio
 * @package Sidep\Dominio\ServidoresPublicos\Repositorios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
interface ServidoresPublicosRepositorio extends Repositorio
{
	/**
	 * guardar cambios en BD
	 * @param  ServidorPublico $servidor
	 * @return bool
	 */
	public function guardar(ServidorPublico $servidor);

	/**
	 * obtener por curp
	 * @param  string $curp
	 * @return ServidorPublico
	 */
	public function obtenerPorCurp($curp);
}