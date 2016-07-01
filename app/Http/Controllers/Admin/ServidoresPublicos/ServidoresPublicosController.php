<?php
namespace Sidep\Http\Controllers\Admin\ServidoresPublicos;

use \DateTime;
use Sidep\Aplicacion\ColeccionArray;
use Sidep\Aplicacion\TransformadorMayusculas;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;
use Sidep\Dominio\ServidoresPublicos\Domicilio;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\Movimiento;
use Sidep\Dominio\ServidoresPublicos\MovimientoTipo;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DependenciasRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\EncargosRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\PuestosRepositorio;
use Illuminate\Http\Request;
use Sidep\Dominio\ServidoresPublicos\Repositorios\ServidoresPublicosRepositorio;
use Sidep\Dominio\ServidoresPublicos\ServidorPublico;
use Sidep\Http\Controllers\Controller;
use Sidep\Http\Requests\FormAltaRequest;
use Sidep\Http\Requests\FormEditarServidorPublico;

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
     * obtener los últimos 50 encargos generados
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $encargos = $this->encargosRepositorio->obtenerTodos();
        return view('admin.servidores_publicos.servidores_publicos', compact('encargos'));
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

    /**
     * buscar un servidor público para el formulario de alta
     * se puede buscar por nombres, curp, rfc o dependencia
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function busqueda(Request $request)
    {
        $datoBusqueda = str_replace(' ', '', $request->get('dato'));
        $encargos     = $this->encargosRepositorio->obtenerEncargos($datoBusqueda);
        $origen       = $request->get('origen');
        $respuesta    = [];

        $encargos === null ? $respuesta['resultado'] = 'fail' : $respuesta['resultado'] = 'OK';

        switch ($origen) {
            case 'alta':
                $vista = view('admin.servidores_publicos.servidores_publicos_encargo_resultados',
                    compact('encargos'))->render();
                break;

            case 'index':
                $vista = view('admin.servidores_publicos.servidores_publicos_resultado_busqueda',
                    compact('encargos'))->render();
                break;
        }

        $respuesta['contenido'] = $vista;

        return response()->json($respuesta);
    }

    /**
     * registrar un nuevo encargo en el sistema
     * @param FormAltaRequest $request
     * @param DependenciasRepositorio $dependenciasRepositorio
     * @param PuestosRepositorio $puestosRepositorio
     * @param ServidoresPublicosRepositorio $servidoresRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws \Sidep\Dominio\Excepciones\NoEsDeclaracionInicialException
     * @throws \Sidep\Dominio\Excepciones\NoEsMovimientoDeAltaException
     */
    public function registrarEncargo(FormAltaRequest $request, DependenciasRepositorio $dependenciasRepositorio, PuestosRepositorio $puestosRepositorio, ServidoresPublicosRepositorio $servidoresRepositorio)
    {
        // transformar a mayúsculas
        $transformador = new TransformadorMayusculas();
        $transformador->transformar($request);

        // logica de guardado de servidor - encargo - movimiento - declaración
        $exento             = $request->get('exento') === 'on' ? true : false;
        $idPuesto           = (int)$request->get('puesto');
        $idDependencia      = (int)$request->get('dependencia');
        $servidorRegistrado = (int)$request->get('servidorRegistrado');
        $respuesta          = [];
        // **********************************************************************
        if ($servidorRegistrado === 0) {
            // crear objeto servidor
            $servidor = new ServidorPublico();

            $servidor->registrar(
                $request->get('nombre'),
                $request->get('paterno'),
                $request->get('materno'),
                $request->get('rfc'),
                $request->get('curp'),
                DateTime::createFromFormat('d/m/Y', $request->get('fechaNacimiento')),
                new Domicilio(
                    $request->get('calle'),
                    $request->get('noExterior'),
                    $request->get('noInterior'),
                    $request->get('coloniaLocalidad'),
                    $request->get('cp'),
                    $request->get('municipio')
                ),
                (int)$request->get('estadoCivil'),
                $request->get('telefono'),
                $request->get('email')
            );

        } else {
            $idServidorPublico = (int)$request->get('idServidorPublico');
            // obtener objeto servidor por Id
            $servidor = $servidoresRepositorio->obtenerPorId($idServidorPublico);
        }

        // obtener puesto por id
        $puesto      = $puestosRepositorio->obtenerPorId($idPuesto);
        // obtener dependencia por id
        $dependencia = $dependenciasRepositorio->obtenerPorId($idDependencia);
        // **********************************************************************
        $encargo     = new Encargo($servidor, $request->get('adscripcion'), new CuentaAcceso(), $puesto, $dependencia, new ColeccionArray(), new ColeccionArray());
        // generar declaracion
        $declaracion = new Declaracion(DeclaracionTipo::INICIAL, new DateTime(), $encargo);

        // generar movimiento
        $movimiento = new Movimiento(MovimientoTipo::ALTA, new DateTime(), $encargo);

        // generar alta
        $encargo->alta($exento, $movimiento, $declaracion, $request->get('fechaIngreso'));

        // **********************************************************************
        // persistir encargo
        $respuesta['resultado'] = 'OK';

        if (!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['resultado'] = 'fail';
        }

        return response()->json($respuesta);
    }

    /**
     * ver la informacion completa de un encargo en base a su id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function detalle(Request $request)
    {
        $id        = (int)base64_decode($request->get('id'));
        $respuesta = [];
        $encargo   = $this->encargosRepositorio->obtenerPorId($id);

        $respuesta['contenido'] = view('admin.servidores_publicos.servidores_publicos_ficha', compact('encargo'))->render();

        return response()->json($respuesta);
    }

    /**
     * ver la pantalla de editar datos personales de servidor público
     * @param int $id
     * @param ServidoresPublicosRepositorio $servidoresRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editarDatos($id, ServidoresPublicosRepositorio $servidoresRepositorio)
    {
        $id       = (int) $id;
        $servidor = $servidoresRepositorio->obtenerPorId($id);

        return view('admin.servidores_publicos.servidores_publicos_editar', compact('servidor'));
    }

    public function actualizar(FormEditarServidorPublico $request, ServidoresPublicosRepositorio $servidoresRepositorio)
    {
        $respuesta = [];
        $servidor  = $servidoresRepositorio->obtenerPorId((int)$request->get('idServidorPublico'));

        // actualizar datos
        $servidor->registrar(
            $request->get('nombre'),
            $request->get('paterno'),
            $request->get('materno'),
            $request->get('rfc'),
            $request->get('curp'),
            DateTime::createFromFormat('d/m/Y', $request->get('fechaNacimiento')),
            new Domicilio(
                $request->get('calle'),
                $request->get('noExterior'),
                $request->get('noInterior'),
                $request->get('coloniaLocalidad'),
                $request->get('cp'),
                $request->get('municipio')
            ),
            (int)$request->get('estadoCivil'),
            $request->get('telefono'),
            $request->get('email')
        );

        $respuesta['resultado'] = 'OK';

        // persistir cambios
        if (!$servidoresRepositorio->actualizar($servidor)) {
            $respuesta['resultado'] = 'fail';
        }

        return response()->json($respuesta);
    }
}