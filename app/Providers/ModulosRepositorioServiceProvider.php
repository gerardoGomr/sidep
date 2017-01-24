<?php

namespace Sidep\Providers;

use Illuminate\Support\ServiceProvider;
use Sidep\Infraestructura\Usuarios\DoctrineModulosRepositorio;

class ModulosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('Sidep\Dominio\Usuarios\Repositorios\ModulosRepositorio', function($app) {
            return new DoctrineModulosRepositorio($app['em']);
        });
    }
}
