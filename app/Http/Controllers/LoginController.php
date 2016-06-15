<?php
namespace Sidep\Http\Controllers;

use Doctrine\ORM\EntityManager;
use Illuminate\Http\Request;
use Sidep\Aplicacion\LoguearEncargos;
use Sidep\Http\Requests;
use Sidep\Infraestructura\ServidoresPublicos\DoctrineEncargosRepositorio;

/**
 * Class LoginController
 * @package Sidep\Http\Controllers
 * @author Gerardo Adrián Gómez Ruiz
 * @version 2.0
 */
class LoginController extends Controller
{
    /**
     * loguear usuario al verificar que el encargo del servidor publico exista
     * y que la contraseña escrita coincida con la almacenada
     * @param Request $request
     * @param EntityManager $entityManager
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|LoginController
     */
    public function login(Request $request, EntityManager $entityManager)
    {
        $logueo = LoguearEncargos::loguear($request, new DoctrineEncargosRepositorio($entityManager));

        if ($logueo->login()) {;
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
        $salir = LoguearEncargos::salir($request);
        $salir->logout();
        return redirect('admin');
    }
}
