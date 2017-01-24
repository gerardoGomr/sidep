<?php
namespace Sidep\Http\Controllers\Admin\Consultas;

use DateTime;
use Exception;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sidep\Dominio\Folios\Repositorios\FoliosRepositorio;
use Sidep\Dominio\ServidoresPublicos\DeclaracionEstatus;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DeclaracionesRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\DependenciasRepositorio;
use Sidep\Dominio\ServidoresPublicos\Repositorios\MovimientosRepositorio;
use Sidep\Exceptions\SidepLogger;
use Sidep\Http\Controllers\Controller;

/**
 * Class ConsultasController
 * @package Sidep\Http\Controllers\Admin\Consultas
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ConsultasController extends Controller
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
     * ConsultasController constructor.
     * @param DependenciasRepositorio $dependenciasRepositorio
     * @param MovimientosRepositorio $movimientosRepositorio
     * @param DeclaracionesRepositorio $declaracionesRepositorio
     */
    public function __construct(DependenciasRepositorio $dependenciasRepositorio, MovimientosRepositorio $movimientosRepositorio, DeclaracionesRepositorio $declaracionesRepositorio)
    {
        $this->dependenciasRepositorio  = $dependenciasRepositorio;
        $this->movimientosRepositorio   = $movimientosRepositorio;
        $this->declaracionesRepositorio = $declaracionesRepositorio;
    }

    /**
     * devolver la vista del reporte
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reporteDelDia()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();
        return view('admin.consultas.reporte_del_dia', compact('dependencias'));
    }

    /**
     * buscar encargos que cumplan con el parámetro
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarMovimientosDia(Request $request)
    {
        $parametros = [
            'dependencia' => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'      => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'      => $request->has('fecha2') ? $request->get('fecha2') : null
        ];
        $respuesta = [];

        $movimientos = $this->movimientosRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.consultas.reporte_del_dia_resultados', compact('movimientos'))->render();

        return response()->json($respuesta);
    }

    /**
     * exportar los resultados de los movimientos al formato establecido
     * @param Request $request
     */
    public function exportarMovimientosDia(Request $request)
    {
        $parametros = [
            'dependencia' => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'      => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'      => $request->has('fecha2') ? $request->get('fecha2') : null
        ];

        $movimientos = $this->movimientosRepositorio->obtenerPor($parametros);

        if ($request->get('opcion') === 'excel') {
            $this->exportarMovimientosDiaExcel($movimientos);
        }
    }

    /**
     * genera el excel con la opción de descargar (abrir o guardar)
     * @param array $movimientos
     */
    private function exportarMovimientosDiaExcel(array $movimientos)
    {
        Excel::create('Movimientos_Nominales_' . (new DateTime())->format('d/m/Y'), function($excel) use($movimientos) {
            $excel->sheet('Hoja 1', function($sheet) use($movimientos) {
                $sheet->loadView('admin.consultas.reporte_del_dia_resultados_tabla', compact('movimientos'));
            });
        })->download('xlsx');
    }

    /**
     * mostrar un listado de declaraciones no realizadas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function declaracionesNoRealizadas()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();
        return view('admin.consultas.declaraciones_no_realizadas', compact('dependencias'));
    }

    /**
     * buscar las declaraciones no realizadas por los parámetros especificados
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarDeclaracionesNoRealizadas(Request $request)
    {
        $parametros = [
            'dependencia' => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'      => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'      => $request->has('fecha2') ? $request->get('fecha2') : null,
            'realizada'   => false
        ];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.consultas.declaraciones_no_realizadas_resultados', compact('declaraciones'))->render();

        return response()->json($respuesta);
    }

    /**
     * buscar las declaraciones y mandar a exportar
     * @param Request $request
     */
    public function exportarDeclaracionesNoRealizadas(Request $request)
    {
        $parametros = [
            'dependencia' => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'      => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'      => $request->has('fecha2') ? $request->get('fecha2') : null,
            'realizada'   => false
        ];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        if ($request->get('opcion') === 'excel') {
            $this->exportarDeclaracionesNoRealizadasExcel($declaraciones);
        }
    }

    /**
     * exportar las declaraciones encontradas a excel
     * @param array $declaraciones
     */
    private function exportarDeclaracionesNoRealizadasExcel(array $declaraciones)
    {
        Excel::create('Declaraciones_no_realizadas_' . (new DateTime())->format('d/m/Y'), function($excel) use($declaraciones) {
            $excel->sheet('Hoja 1', function($sheet) use($declaraciones) {
                $sheet->loadView('admin.consultas.declaraciones_no_realizadas_resultados_tabla', compact('declaraciones'));
            });
        })->download('xlsx');
    }

    /**
     * mostrar la vista de omisos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function omisos()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();
        return view('admin.consultas.omisos', compact('dependencias'));
    }

    /**
     * buscar omisos
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function buscarOmisos(Request $request)
    {
        $parametros = [
            'dependencia'     => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'declaracionTipo' => !empty($request->get('declaracionTipo')) ? $request->get('declaracionTipo') : null,
            'estatus'         => DeclaracionEstatus::PENDIENTE_EXTEMPORANEA,
            'fecha1'          => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'          => $request->has('fecha2') ? $request->get('fecha2') : null,
            'realizada'       => false,
            'requerimiento'   => false
        ];
        $respuesta = [];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.consultas.omisos_resultados', compact('declaraciones'))->render();

        return response()->json($respuesta);
    }

    /**
     * marcar a omisos
     * @param Request $request
     * @param FoliosRepositorio $foliosRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function marcarOmisos(Request $request, FoliosRepositorio $foliosRepositorio)
    {
        $fechaMarcado = $request->get('fechaMarcado');
        $respuesta    = [];

        foreach ($request->get('declaracionId') as $declaracionId) {
            $declaracionId = (int)base64_decode($declaracionId);

            $folio = $foliosRepositorio->obtenerFolioParaRequerimiento(date('Y'));

            $declaracion = $this->declaracionesRepositorio->obtenerPorId($declaracionId);
            $declaracion->marcarComoOmiso(DateTime::createFromFormat('d/m/Y', $fechaMarcado), $folio);

            if (!$foliosRepositorio->actualizar($folio)) {
                $respuesta['estatus'] = 'fail';

                return response()->json($respuesta);
            }

            if (!$this->declaracionesRepositorio->actualizar($declaracion)) {
                $respuesta['estatus'] = 'fail';

                return response()->json($respuesta);
            }
        }

        $respuesta['estatus'] = 'OK';
        return response()->json($respuesta);
    }

    /**
     * genera la vista para la administración de declaraciones ya marcadas con requerimientos
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function desmarcarOmisosMostrar()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();
        return view('admin.consultas.omisos_desmarcar', compact('dependencias'));
    }

    /**
     * buscar omisos para desmarcarlos
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function desmarcarOmisosBuscar(Request $request)
    {
        $parametros = [
            'dependencia'   => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'requerimiento' => true,
            'datoServidor'  => !empty($request->get('servidor')) ? $request->get('servidor') : null,
        ];
        $respuesta = [];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.consultas.omisos_desmarcar_resultados', compact('declaraciones'))->render();

        return response()->json($respuesta);
    }

    /**
     * desmarcar el estatus de omiso a la declaración enviada
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function desmarcarOmisos(Request $request)
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
            return response()->json($respuesta);

        } catch(Exception $e) {
            $pdoLogger = new SidepLogger(new Logger('exception'), new StreamHandler(storage_path() . '/logs/exceptions/exc_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

            $respuesta['estatus'] = 'fail';
            $respuesta['mensaje'] = $e->getMessage();
            return response()->json($respuesta);
        }
    }

    /**
     * mostrar la vista de las declaraciones realizadas
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function declaracionesRealizadas()
    {
        $dependencias = $this->dependenciasRepositorio->obtenerTodos();
        return view('admin.consultas.declaraciones_realizadas', compact('dependencias'));
    }

    /**
     * buscar declaraciones realizadas
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function declaracionesRealizadasBuscar(Request $request)
    {
        $parametros = [
            'dependencia' => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'      => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'      => $request->has('fecha2') ? $request->get('fecha2') : null,
            'realizada'   => true
        ];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.consultas.declaraciones_realizadas_resultados', compact('declaraciones'))->render();

        return response()->json($respuesta);
    }

    /**
     * buscar las declaraciones realizadas y mandarlas a exportar
     * @param Request $request
     */
    public function declaracionesRealizadasExportar(Request $request)
    {
        $parametros = [
            'dependencia' => $request->has('dependencia') ? (int)$request->get('dependencia') : null,
            'fecha1'      => $request->has('fecha1') ? $request->get('fecha1') : null,
            'fecha2'      => $request->has('fecha2') ? $request->get('fecha2') : null,
            'realizada'   => true
        ];

        $declaraciones = $this->declaracionesRepositorio->obtenerPor($parametros);

        if ($request->get('opcion') === 'excel') {
            $this->declaracionesRealizadasExportarExcel($declaraciones);
        }
    }

    /**
     * generar excel de las declaraciones realizadas
     * @param array $declaraciones
     */
    private function declaracionesRealizadasExportarExcel(array $declaraciones)
    {
        Excel::create('Declaraciones_realizadas_' . (new DateTime())->format('d/m/Y'), function($excel) use($declaraciones) {
            $excel->sheet('Hoja 1', function($sheet) use($declaraciones) {
                $sheet->loadView('admin.consultas.declaraciones_realizadas_resultados_tabla', compact('declaraciones'));
            });
        })->download('xlsx');
    }
}