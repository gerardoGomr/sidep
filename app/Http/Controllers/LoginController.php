<?php
namespace Sidep\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Sidep\Aplicacion\LoguearEncargos;
use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Sidep\Http\Requests;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineEncargosRepositorio;
use Sidep\Jobs\GuardarAccionDeEncargo;

/**
 * Class LoginController
 * @package Sidep\Http\Controllers
 * @author Gerardo Adrián Gómez Ruiz
 * @version 2.0
 */
class LoginController extends Controller
{
    /**
     * @var EncargosRepositorio
     */
    private $encargosRepositorio;

    /**
     * LoginController constructor.
     * @param EncargosRepositorio $encargosRepositorio
     */
    public function __construct(EncargosRepositorio $encargosRepositorio)
    {
        $this->encargosRepositorio = $encargosRepositorio;
    }


    /**
     * loguear usuario al verificar que el encargo del servidor publico exista
     * y que la contraseña escrita coincida con la almacenada
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|LoginController
     */
    public function login(Request $request)
    {
        $logueo = LoguearEncargos::loguear($request, $this->encargosRepositorio);

        if ($logueo->login()) {
            (new GuardarAccionDeEncargo('INICIÓ SESIÓN EXITOSAMENTE', session('encargo')))->handle();

            return redirect('admin');
        }

        return $this->loginError();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    private function loginError()
    {
        return view('admin.login')->with('error', 'Usuario y/o contraseña incorrectos');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        (new GuardarAccionDeEncargo('CERRÓ SESIÓN', session('encargo')))->handle();

        $salir = LoguearEncargos::salir($request);
        $salir->logout();
        return redirect('admin');
    }
}
