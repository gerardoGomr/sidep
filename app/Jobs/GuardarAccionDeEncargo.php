<?php

namespace Sidep\Jobs;

use DateTime;
use Sidep\Aplicacion\Modelos\EncargoSeguimiento;
use Sidep\Aplicacion\Modelos\Repositorios\EncargosSeguimientosRepositorio;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineEncargosRepositorio;
use Sidep\Infraestructura\Usuarios\DoctrineEncargosSeguimientosRepositorio;

/**
 * Class GuardarAccionDeEncargo
 * @package Sidep\Jobs
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class GuardarAccionDeEncargo
{
    /**
     * @var EncargosSeguimientosRepositorio
     */
    private $encargosSeguimientosRepositorio;

    /**
     * @var EncargoSeguimiento
     */
    private $encargoSeguimiento;

    /**
     * @var DoctrineEncargosRepositorio
     */
    private $encargosRepositorio;

    /**
     * Create a new job instance.
     *
     * @param string $accion
     * @param Encargo $encargo
     */
    public function __construct($accion, Encargo $encargo)
    {
        $this->encargosSeguimientosRepositorio = new DoctrineEncargosSeguimientosRepositorio(\App::getInstance()['em']);
        $this->encargosRepositorio             = new DoctrineEncargosRepositorio(\App::getInstance()['em']);
        $encargo = $this->encargosRepositorio->obtenerPorId($encargo->getId());

        $this->encargoSeguimiento              = new EncargoSeguimiento($encargo, new DateTime(), $accion);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->encargosSeguimientosRepositorio->persistir($this->encargoSeguimiento);
    }
}
