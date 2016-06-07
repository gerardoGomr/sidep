<?php
namespace Sidep\Providers;

use Illuminate\Support\ServiceProvider;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineEncargosC3Repositorio;
use Doctrine\ORM\EntityManagerInterface;
use App;

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
        $this->app->bind('Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio', function($app) {
            return new DoctrineEncargosC3Repositorio(App::make('Doctrine\ORM\EntityManagerInterface'));
        });
    }
}
