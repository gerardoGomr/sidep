<?php

namespace Sidep\Providers;

use Illuminate\Support\ServiceProvider;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineServidoresPublicosRepositorio;
use Doctrine\ORM\EntityManagerInterface;
use App;

class ServidoresPublicosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('Sidep\Dominio\ServidoresPublicos\Repositorios\ServidoresPublicosRepositorio', function() {
            return new DoctrineServidoresPublicosRepositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
