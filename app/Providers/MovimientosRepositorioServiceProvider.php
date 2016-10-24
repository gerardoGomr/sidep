<?php

namespace Sidep\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineMovimientosRepositorio;

class MovimientosRepositorioServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Sidep\Dominio\ServidoresPublicos\Repositorios\MovimientosRepositorio', function($app) {
            return new DoctrineMovimientosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
