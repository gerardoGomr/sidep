<?php

namespace Sidep\Http\Middleware;

use Closure;
use Sidep\Aplicacion\Menu\ConstructorMenu;
use Sidep\Dominio\Usuarios\Repositorios\ModulosRepositorio;

class CrearMenu
{
    /**
     * @var ModulosRepositorio
     */
    private $modulosRepositorio;

    /**
     * CrearMenu constructor.
     * @param ModulosRepositorio $modulosRepositorio
     */
    public function __construct(ModulosRepositorio $modulosRepositorio)
    {
        $this->modulosRepositorio = $modulosRepositorio;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $modulos         = $this->modulosRepositorio->obtenerTodos();
        $encargo         = $request->session()->get('encargo');
        $constructorMenu = new ConstructorMenu($encargo);
        $menu            = $constructorMenu->construir($modulos);

        view()->share('menu', $menu);
        return $next($request);
    }
}
