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
        $respuesta    = [];

        if ($encargos === null) {
            $respuesta['resultado'] = 'fail';
        } else {
            $respuesta['resultado'] = 'OK';
            $respuesta['contenido'] = view('admin.servidores_publicos.servidores_publicos_encargo_resultados',
                compact('encargos'))->render();
        }

        return response()->json($respuesta);
    }

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
            $servidor = new ServidorPublico($request->get('nombre'), $request->get('paterno'), $request->get('materno'), $request->get('rfc'));
            $servidor->registrar($request->get('curp'), DateTime::createFromFormat('d/m/Y', $request->get('fechaNacimiento')), new Domicilio($request->get('calle'), $request->get('noExterior'), $request->get('noInterior'), $request->get('coloniaLocalidad'), $request->get('cp'), $request->get('municipio')));

        } else {
            $idServidorPublico = (int)$request->get('idServidorPublico');
            // obtener objeto servidor por Id
            $servidor = $servidoresRepositorio->obtenerPorId($idServidorPublico);
        }

        // obtener puesto por id
        $puesto = $puestosRepositorio->obtenerPorId($idPuesto);
        // obtener dependencia por id
        $dependencia = $dependenciasRepositorio->obtenerPorId($idDependencia);
        // **********************************************************************
        $encargo = new Encargo($servidor, $request->get('adscripcion'), new CuentaAcceso(), $puesto, $dependencia, new ColeccionArray(), new ColeccionArray());

        $declaracion = new Declaracion(DeclaracionTipo::INICIAL, new DateTime());
        $declaracion->generarFechaDeCumplimiento();

        $movimiento = new Movimiento(MovimientoTipo::ALTA, new DateTime());
        $movimiento->generarComentario();
        $encargo->alta($exento, $movimiento, $declaracion);
        // **********************************************************************
        // persistir encargo
        $respuesta['resultado'] = 'OK';

        if (!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['resultado'] = 'fail';
        }

        return response()->json($respuesta);
    }
}
