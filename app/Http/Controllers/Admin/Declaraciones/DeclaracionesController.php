<?php
namespace Sidep\Http\Controllers\Admin\Declaraciones;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Sidep\Aplicacion\Reporte;
use Sidep\Aplicacion\Reportes\RequerimientoCrystalReports;
use Sidep\Aplicacion\Reportes\SancionCrystalReports;
use Sidep\Dominio\Declaraciones\OficioRequerimiento;
use Sidep\Dominio\Folios\Repositorios\FoliosRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DeclaracionesRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DependenciasRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\MovimientosRepositorio;
use Sidep\Exceptions\SidepLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sidep\Jobs\GuardarAccionDeEncargo;
use Sidep\Http\Controllers\Controller;

/**
 * Class Declaracionescontroller
 * @package Sidep\Http\Controllers\Admin\Declaraciones
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class Declaracionescontroller extends Controller
{
    /**
     * @var DependenciasRepositorio
     */
    private $dependenciasRepositorio;

    /**
     * @var MovimientosRepositorio
     */
    private $movimientosRepositorio;

    /**
     * @var DeclaracionesRepositorio
     */
    private $declaracionesRepositorio;

    /**
     * DeclaracionesController constructor.
     * @param DependenciasRepositorio $dependenciasRepositorio
     * @param DeclaracionesRepositorio $declaracionesRepositorio
     */
    public function __construct(DependenciasRepositorio $dependenciasRepositorio, DeclaracionesRepositorio $declaracionesRepositorio)
    {
        $this->dependenciasRepositorio  = $dependenciasRepositorio;
        $this->declaracionesRepositorio = $declaracionesRepositorio;
    }

    /**
     * mostrar vista de requerimientos generados
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function requerimientos()
    {
        $parametros = [
            'realizada'     => false,
            'requerimiento' => true
        ];

        $dependencias  = $this->dependenciasRepositorio->obtenerTodos();
        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        (new GuardarAccionDeEncargo('INGRESÓ A VER LISTADO DE REQUERIMIENTOS', session('encargo')))->handle();

        return view('admin.declaraciones.requerimientos', compact('declaraciones', 'dependencias'));
    }

    /**
     * buscar requerimientos (declaraciones con el estatus de requerimiento = true & que no se haya retornado)
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function requerimientosBuscar(Request $request)
    {
        $parametros = [
            'dependencia'   => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'        => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'        => $request->has('fecha2') ? $request->get('fecha2') : null,
            'datoServidor'  => !empty($request->get('servidor')) ? $request->get('servidor') : null,
            'realizada'     => false,
            'requerimiento' => true
        ];
        $respuesta = [];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.declaraciones.requerimientos_resultados', compact('declaraciones'))->render();

        (new GuardarAccionDeEncargo('BUSCÓ DECLARACIONES EN LISTADO DE REQUERIMIENTOS: [' . serialize($parametros) . ']', session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * eliminar el estatus de omiso a la declaración
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function requerimientoEliminar(Request $request)
    {
        $declaracionId = (int)base64_decode($request->get('declaracionId'));
        $declaracion   = $this->declaracionesRepositorio->obtenerPorId($declaracionId);

        try {
            $declaracion->desmarcarOmiso();
            if (!$this->declaracionesRepositorio->actualizar($declaracion)) {
                $respuesta['estatus'] = 'fail';

                return response()->json($respuesta);
            }

            $respuesta['estatus'] = 'OK';

        } catch(Exception $e) {
            $pdoLogger = new SidepLogger(new Logger('exception'), new StreamHandler(storage_path() . '/logs/exceptions/exc_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = $e->getMessage();

        } finally {
            (new GuardarAccionDeEncargo('ELIMINÓ EL REQUERIMIENTO DE LA DECLARACIÓN: [' . serialize($declaracion) . ']', session('encargo')))->handle();

            return response()->json($respuesta);
        }
    }

    /**
     * generar el requerimiento en PDF
     * @param $declaracionId
     * @return mixed
     */
    public function requerimientoPdf($declaracionId)
    {
        $declaracionId = (int)base64_decode($declaracionId);
        $declaracion   = $this->declaracionesRepositorio->obtenerPorId($declaracionId);

        $declaracion->seAbrioElRequerimiento();
        $this->declaracionesRepositorio->actualizar($declaracion);

        $reporte = new Reporte(new RequerimientoCrystalReports($declaracion));

        (new GuardarAccionDeEncargo('GENERÓ EL REQUERIMIENTO EN PDF: [' . serialize($declaracion) . ']', session('encargo')))->handle();

        if ($reporte->existe()) {
            return response()->file($reporte->ruta());
        }

        if ($reporte->generar()) {
            return response()->file($reporte->ruta());
        }
    }

    /**
     * mostrar vista de retorno de requerimientos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function retornoRequerimientos()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();

        (new GuardarAccionDeEncargo('INGRESÓ A VISUALIZAR EL RETORNO DE REQUERIMIENTOS', session('encargo')))->handle();
        return view('admin.declaraciones.requerimientos_retorno', compact('dependencias'));
    }

    /**
     * buscar declaraciones
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function retornoRequerimientosBuscar(Request $request)
    {
        $parametros = [
            'requerimiento'               => true,
            'seHaRetornadoRequerimiento'  => false,
            'datoServidor'                => !empty($request->get('servidor')) ? $request->get('servidor') : null,
            'dependencia'                 => !empty($request->get('dependencia')) ? (int)$request->get('dependencia') : null
        ];

        $respuesta     = [];
        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.declaraciones.requerimientos_retorno_resultados', compact('declaraciones'))->render();

        (new GuardarAccionDeEncargo('BUSCÓ DECLARACIONES EN LISTADO DE RETORNO DE REQUERIMIENTOS: [' . serialize($parametros) . ']', session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * marcar el retorno de requerimientos
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function retornoRequerimientosMarcar(Request $request)
    {
        $numeroOficio = $request->get('numeroOficio');
        $fechaOficio  = $request->get('fechaOficio');
        $respuesta    = [];

        $oficio = new OficioRequerimiento($numeroOficio, DateTime::createFromFormat('d/m/Y', $fechaOficio));

        foreach ($request->get('declaracionId') as $declaracionId) {
            $declaracionId = (int)base64_decode($declaracionId);

            $declaracion = $this->declaracionesRepositorio->obtenerPorId($declaracionId);
            $declaracion->marcarRetornoDeRequerimiento($oficio);

            if (!$this->declaracionesRepositorio->actualizar($declaracion)) {
                $respuesta['estatus'] = 'fail';

                return response()->json($respuesta);
            }
        }

        (new GuardarAccionDeEncargo('MARCÓ EL RETORNO DE REQUERIMIENTOS CON EL OFICIO: [' . serialize($oficio) . '] Y LAS DECLARACIONES [' . serialize($request->get('declaracionId')) . ']', session('encargo')))->handle();

        $respuesta['estatus'] = 'OK';
        return response()->json($respuesta);
    }

    /**
     * mostrar la vista de la desmarcación del retorno de requerimientos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function requerimientosDesmarcarMostrar()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();
        (new GuardarAccionDeEncargo('INGRESÓ A DESMARCAR REQUERIMIENTOS', session('encargo')))->handle();

        return view('admin.declaraciones.requerimientos_desmarcar', compact('dependencias'));
    }

    /**
     * buscar declaraciones que tenga estatus de requerimiento y que ya se haya marcado el retorno
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function requerimientosDesmarcarBuscar(Request $request)
    {
        $parametros = [
            'requerimiento'              => true,
            'seHaRetornadoRequerimiento' => true,
            'datoServidor'               => !empty($request->get('servidor')) ? $request->get('servidor') : null,
            'dependencia'                => !empty($request->get('dependencia')) ? (int)$request->get('dependencia') : null
        ];

        $respuesta     = [];
        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.declaraciones.requerimientos_desmarcar_resultados', compact('declaraciones'))->render();

        return response()->json($respuesta);
    }

    /**
     * desmarcar la recepción del requerimiento
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function requerimientosDesmarcar(Request $request)
    {
        $declaracionId = (int)base64_decode($request->get('declaracionId'));
        $declaracion   = $this->declaracionesRepositorio->obtenerPorId($declaracionId);

        $declaracion->desmarcarRecepcionRequerimiento();
        if (!$this->declaracionesRepositorio->actualizar($declaracion)) {
            $respuesta['estatus'] = 'fail';

            return response()->json($respuesta);
        }

        $respuesta['estatus'] = 'OK';
        return response()->json($respuesta);
    }

    /**
     * mostrar vista de envíos a Secretaría de Función Pública
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mostrarMarcarEnviosSFP()
    {
        $parametros = [
            'realizada'                  => false,
            'requerimiento'              => true,
            'seHaRetornadoRequerimiento' => true,
            'sancionada'                 => false,
            'fechaVencida'               => true
        ];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);
        $dependencias  = $this->dependenciasRepositorio->obtenerTodos();

        (new GuardarAccionDeEncargo('INGRESÓ A MARCAR DECLARACIONES PARA ENVÍO A SFP', session('encargo')))->handle();

        return view('admin.declaraciones.envios_sfp', compact('dependencias', 'declaraciones'));
    }

    /**
     * buscar declaraciones con las coincidencias de búsqueda
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function enviosSFPBuscar(Request $request)
    {
        $parametros = [
            'realizada'                  => false,
            'requerimiento'              => true,
            'datoServidor'               => !empty($request->get('servidor')) ? $request->get('servidor') : null,
            'dependencia'                => !empty($request->get('dependencia')) ? (int)$request->get('dependencia') : null,
            'seHaRetornadoRequerimiento' => true,
            'sancionada'                 => false,
            'fechaVencida'               => true
        ];

        $respuesta     = [];
        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.declaraciones.envios_sfp_resultados', compact('declaraciones'))->render();

        (new GuardarAccionDeEncargo('BUSCÓ DECLARACIONES DESDE EL MÓDULO DE ENVÍO A SFP [' . serialize($parametros) . ']', session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * marcar a los seleccionados que ya fueron enviados a la SFP
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function marcarEnviosSFP(Request $request, FoliosRepositorio $foliosRepositorio)
    {
        $fechaMarcado = $request->get('fechaMarcado');
        $respuesta    = [];

        foreach ($request->get('declaracionId') as $declaracionId) {
            $folio = $foliosRepositorio->obtenerFolioParaEnvioASFP(date('Y'));

            $declaracionId = (int)base64_decode($declaracionId);

            $declaracion = $this->declaracionesRepositorio->obtenerPorId($declaracionId);
            $declaracion->marcarEnvioASFP(DateTime::createFromFormat('d/m/Y', $fechaMarcado), $folio);

            if (!$this->declaracionesRepositorio->actualizar($declaracion)) {
                $respuesta['estatus'] = 'fail';

                return response()->json($respuesta);
            }
        }

        (new GuardarAccionDeEncargo('MARCAR A LAS DECLARACIONES PARA ENVÍO A SFP [' . serialize($request->get('declaracionId')) . ']', session('encargo')))->handle();

        $respuesta['estatus'] = 'OK';
        return response()->json($respuesta);
    }

    /**
     * generar la vista para mostrar a los que ya fueron enviados a la SFP
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mostrarEnviadosASFP()
    {
        $parametros = [
            'requerimiento'              => true,
            'seHaRetornadoRequerimiento' => true,
            'sancionada'                 => true
        ];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);
        $dependencias  = $this->dependenciasRepositorio->obtenerTodos();

        (new GuardarAccionDeEncargo('INGRESÓ A MOSTRAR LISTA DE ENVIADOS A SFP', session('encargo')))->handle();
        return view('admin.declaraciones.enviados_sfp', compact('dependencias', 'declaraciones'));
    }

    /**
     * buscar declaraciones con las coincidencias de búsqueda
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function enviadosSFPBuscar(Request $request)
    {
        $parametros = [
            'requerimiento'              => true,
            'datoServidor'               => !empty($request->get('servidor')) ? $request->get('servidor') : null,
            'dependencia'                => !empty($request->get('dependencia')) ? (int)$request->get('dependencia') : null,
            'seHaRetornadoRequerimiento' => true,
            'sancionada'                 => true
        ];

        $respuesta     = [];
        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.declaraciones.enviados_sfp_resultados', compact('declaraciones'))->render();

        (new GuardarAccionDeEncargo('BUSCÓ DECLARACIONES DESDE MÓDULO DE ENVIADOS A SFP [' . serialize($parametros) . ']', session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * remover la sanción de la declaración
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function enviadosSFPEliminar(Request $request)
    {
        $declaracionId = (int)base64_decode($request->get('declaracionId'));
        $declaracion   = $this->declaracionesRepositorio->obtenerPorId($declaracionId);

        $declaracion->removerSancion();

        if (!$this->declaracionesRepositorio->actualizar($declaracion)) {
            $respuesta['estatus'] = 'fail';

            return response()->json($respuesta);
        }

        (new GuardarAccionDeEncargo('REMOVIÓ EL ESTATUS DE ENVIADO A SFP A DECLARACIÓN [' . serialize($declaracion) . ']', session('encargo')))->handle();

        $respuesta['estatus'] = 'OK';
        return response()->json($respuesta);
    }

    /**
     * generar sanción del servidor público en PDF
     * @param $declaracionId
     * @return \Illuminate\Http\Response
     */
    public function envioSancionPDF($declaracionId)
    {
        $declaracionId = (int)base64_decode($declaracionId);
        $declaracion   = $this->declaracionesRepositorio->obtenerPorId($declaracionId);

        $this->declaracionesRepositorio->actualizar($declaracion);

        $reporte = new Reporte(new SancionCrystalReports($declaracion));

        (new GuardarAccionDeEncargo('GENERÓ FORMATO DE ENVÍO A SFP EN PDF', session('encargo')))->handle();

        if ($reporte->existe()) {
            return response()->file($reporte->ruta(), ['Content-Disposition' => 'inline;filename=Descripcion.pdf']);
        }

        if ($reporte->generar()) {
            return response()->file($reporte->ruta(), ['Content-Disposition' => 'inline;filename=Descripcion.pdf']);
        }
    }
}