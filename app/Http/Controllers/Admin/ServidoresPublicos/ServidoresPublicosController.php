<?php
namespace Sidep\Http\Controllers\Admin\ServidoresPublicos;

use Sidep\Dominio\ServidoresPublicos\Repositorios\DependenciasRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\PuestosRepositorio;
use Illuminate\Http\Request;
use Sidep\Http\Controllers\Controller;

/**
 * Class ServidoresPublicosController
 * @package Sidep\Http\Controllers\Admin
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ServidoresPublicosController extends Controller
{
    /**
     * @var EncargosRepositorio
     */
    private $encargosRepositorio;

    /**
     * ServidoresPublicosController constructor.
     * @param EncargosRepositorio $encargosRepositorio
     */
    public function __construct(EncargosRepositorio $encargosRepositorio)
    {
        $this->encargosRepositorio = $encargosRepositorio;
    }

    /**
     * mostrar view principal
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin.servidores_publicos.servidores_publicos');
    }

    /**
     * mostrar view alta de supervisor - encargo
     * @param DependenciasRepositorio $dependenciasRepositorio
     * @param PuestosRepositorio $puestosRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function alta(DependenciasRepositorio $dependenciasRepositorio, PuestosRepositorio $puestosRepositorio)
    {
        $dependencias = $dependenciasRepositorio->obtenerTodos();
        $puestos      = $puestosRepositorio->obtenerTodos();
        return view('admin.servidores_publicos.servidores_publicos_encargo_alta', compact('dependencias', 'puestos'));
    }

    public function busqueda(Request $request)
    {
        $datoBusqueda = str_replace(' ', '', $request->get('dato'));
        $encargos     = $this->encargosRepositorio->obtenerEncargos($datoBusqueda);

        $respuesta    = [
            'resultado' => 'OK',
            'contenido' => view('admin.servidores_publicos.servidores_publicos_encargo_resultados',
                compact('encargos'))->render()
        ];

        return response()->json($respuesta);
    }
}
