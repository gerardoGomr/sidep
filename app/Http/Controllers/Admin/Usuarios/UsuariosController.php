<?php

namespace Sidep\Http\Controllers\Admin\Usuarios;

use DateTime;
use Illuminate\Http\Request;
use Sidep\Aplicacion\ColeccionArray;
use Sidep\Aplicacion\Menu\ConstructorFormModulos;
use Sidep\Dominio\ServidoresPublicos\EncargoPrivilegio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Sidep\Dominio\Usuarios\Repositorios\ModulosRepositorio;
use Sidep\Jobs\GuardarAccionDeEncargo;
use Sidep\Http\Controllers\Controller;

/**
 * Class UsuariosController
 * @package Sidep\Http\Controllers\Admin\Usuarios
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class UsuariosController extends Controller
{
    /**
     * @var EncargosRepositorio
     */
    private $encargosRepositorio;

    /**
     * @var ModulosRepositorio
     */
    private $modulosRepositorio;

    /**
     * UsuariosController constructor.
     * @param EncargosRepositorio $encargosRepositorio
     * @param ModulosRepositorio $modulosRepositorio
     */
    public function __construct(EncargosRepositorio $encargosRepositorio, ModulosRepositorio $modulosRepositorio)
    {
        $this->encargosRepositorio = $encargosRepositorio;
        $this->modulosRepositorio  = $modulosRepositorio;
    }

    /**
     * presenta la vista principal de usuarios
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $parametros = [
            'dependencia'  => 1,
            'activo'       => true,
            'usuarioSidep' => false
        ];

        $encargos = $this->encargosRepositorio->obtenerEncargosPor($parametros);

        $encargosSidep = $this->buscarUsuarios();

        (new GuardarAccionDeEncargo('INGRESÓ A LISTADO DE USUARIOS', session('encargo')))->handle();
        return view('admin.usuarios.usuarios', compact('encargos', 'encargosSidep'));
    }

    /**
     * buscar a usuarios
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscar()
    {
        $respuesta         = ['estatus' => 'OK'];
        $encargosSidep     = $this->buscarUsuarios();
        $respuesta['html'] = view('admin.usuarios.usuarios_resultados', compact('encargosSidep'))->render();

        (new GuardarAccionDeEncargo('BUSCÓ A USUARIOS DESDE EL MÓDULO DE USUARIOS', session('encargo')))->handle();
        return response()->json($respuesta);
    }

    /**
     * buscar usuarios sidep
     * @return array|null
     */
    private function buscarUsuarios()
    {
        $parametros = [
            'usuarioSidep' => true
        ];

        $encargos = $this->encargosRepositorio->obtenerEncargosPor($parametros);

        return $encargos;
    }

    /**
     * generar usuario
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generar(Request $request)
    {
        $encargoId   = (int)$request->get('encargo');
        $tipoUsuario = (int)$request->get('tipoUsuario');
        $respuesta   = [];

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);
        $encargo->generarUsuarioSidep($tipoUsuario);

        $respuesta['estatus'] = 'OK';
        if (!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['estatus'] = 'fail';
        }

        (new GuardarAccionDeEncargo('MARCÓ A UN ENCARGO COMO USUARIO SIDEP', session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * generar la vista del form para asignar privilegios
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generarVistaPrivilegios(Request $request)
    {
        $respuesta = ['estatus' => 'OK'];
        $encargoId = (int)$request->get('encargoId');
        $encargo   = $this->encargosRepositorio->obtenerPorId($encargoId);
        $modulos   = $this->modulosRepositorio->obtenerTodos();

        $constructorFormModulos = new ConstructorFormModulos($encargo);
        $respuesta['html']      = $constructorFormModulos->construir($modulos);

        (new GuardarAccionDeEncargo('SELECCIONÓ ASIGNAR PRIVILEGIOS A USUARIO Y SE PRESENTÓ FORMULARIO', session('encargo')))->handle();
        return response()->json($respuesta);
    }

    /**
     * actualizar privilegios a encargo
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function asignarPrivilegios(Request $request)
    {
        $respuesta     = ['estatus' => 'OK'];
        $encargoId     = (int)$request->get('encargoId');
        $encargo       = $this->encargosRepositorio->obtenerPorId($encargoId);
        $encargoAsigna = $request->session()->get('encargo');

        $encargoAsigna = $this->encargosRepositorio->obtenerPorId($encargoAsigna->getId());

        // remover todos los privilegios
        $encargo->inicializarModulos(new ColeccionArray());
        $encargo->removerPrivilegios();

        if ($request->has('modulos')) {
            foreach ($request->get('modulos') as $moduloId) {
                $modulo = $this->modulosRepositorio->obtenerPorId($moduloId);

                $encargo->asignarPrivilegio(new EncargoPrivilegio($modulo, $encargoAsigna, $encargo, new DateTime()));
            }

            if (!$this->encargosRepositorio->guardar($encargo)) {
                $respuesta['estatus'] = 'fail';
                $respuesta['mensaje'] = 'OCURRIÓ UN ERROR AL GUARDAR EN LA BASE DE DATOS';
            }
        }

        (new GuardarAccionDeEncargo('ASIGNÓ PRIVILEGIOS A USUARIO ' . $encargo->getServidorPublico()->nombreCompleto(), session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * quitar estatus de usuario Sidep
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminar(Request $request)
    {
        $respuesta     = ['estatus' => 'OK'];
        $encargoId     = (int)$request->get('encargoId');
        $encargo       = $this->encargosRepositorio->obtenerPorId($encargoId);

        $encargo->yaNoEsUsuarioSidep();

        if (!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = 'OCURRIÓ UN ERROR AL GUARDAR EN LA BASE DE DATOS';
        }

        (new GuardarAccionDeEncargo('REMOVIÓ A ENCARGO DE SER USUARIO: ' . $encargo->getServidorPublico()->nombreCompleto(), session('encargo')))->handle();

        return response()->json($respuesta);
    }
}