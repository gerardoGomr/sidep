<?php

namespace Sidep\Providers;

use Illuminate\Support\ServiceProvider;

class EncargosRepositorioServiceProvider extends ServiceProvider
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
        $this->app->bind('Sidep\Dominio\ServidoresPublicos\EncargosRepositorio', 'Sidep\Infraestructura\ServidoresPublicos\DoctrineEncargosRepositorio');
    }
}
