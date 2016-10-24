<?php

namespace Sidep\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Sidep\Infraestructura\Folios\DoctrineFoliosRepositorio;

class FoliosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('Sidep\Dominio\Folios\Repositorios\FoliosRepositorio', function($app) {
            return new DoctrineFoliosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
