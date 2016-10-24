<?php

namespace Sidep\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineDeclaracionesRepositorio;

class DeclaracionesRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('Sidep\Dominio\ServidoresPublicos\Repositorios\DeclaracionesRepositorio', function($app) {
            return new DoctrineDeclaracionesRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
