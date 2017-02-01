<?php
namespace Sidep\Http\Controllers\Admin\Configuraciones;

use Exception;
use Illuminate\Http\Request;
use Sidep\Aplicacion\Modelos\DiaFestivoNoOficial;
use Sidep\Aplicacion\Modelos\DiaFestivoOficial;
use Sidep\Exceptions\SidepLogger;
use Sidep\Http\Controllers\Controller;
use Sidep\Http\Requests\AgregarDiaFestivoOficialRequest;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Class ConfiguracionesController
 * @package Sidep\Http\Controllers\Admin\Configuraciones
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ConfiguracionesController extends Controller
{
    /**
     * generar vista de días festivos oficiales
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function diasFestivosOficiales()
    {
        $diasFestivos = DiaFestivoOficial::all();
        return view('admin.configuraciones.dias_festivos_oficiales', compact('diasFestivos'));
    }

    /**
     * buscar días festivos
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function recargarDiasFestivosOficiales()
    {
        $respuesta         = ['estatus' => 'OK'];
        $diasFestivos      = DiaFestivoOficial::all();
        $respuesta['html'] = view('admin.configuraciones.dias_festivos_oficiales_tabla', compact('diasFestivos'))->render();

        return response()->json($respuesta);
    }

    /**
     * crear|actualizar nuevo día festivo
     * @param AgregarDiaFestivoOficialRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agregarDiaFestivoOficial(AgregarDiaFestivoOficialRequest $request)
    {
        $this->transformarMayusculas($request);

        $dia          = (int)$request->get('dia');
        $mes          = (int)$request->get('mes');
        $celebracion  = $request->get('celebracion');
        $diaFestivoId = !empty($request->get('diaFestivoId')) ? (int)$request->get('diaFestivoId') : null;
        $respuesta    = ['estatus' => 'OK'];

        if (!is_null($diaFestivoId)) {
            $diaFestivoOficial = DiaFestivoOficial::find($diaFestivoId);

        } else {
            $diaFestivoOficial = new DiaFestivoOficial();

        }

        $diaFestivoOficial->asignarFecha($dia, $mes, $celebracion);

        try {
            $diaFestivoOficial->save();

        } catch (Exception $e) {
            $respuesta['estatus'] = 'fail';

            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

        } finally {
            return response()->json($respuesta);
        }
    }

    /**
     * eliminar día festivo de la BD
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminarDiaFestivoOficial(Request $request)
    {
        $diaFestivoId = (int)$request->get('diaFestivoId');
        $respuesta    = ['estatus' => 'OK'];

        try {
            DiaFestivoOficial::destroy($diaFestivoId);

        } catch (Exception $e) {
            $respuesta['estatus'] = 'fail';

            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

        } finally {
            return response()->json($respuesta);
        }
    }

    /**
     * generar vista de días festivos no oficiales
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function diasFestivosNoOficiales()
    {
        $diasFestivos = DiaFestivoNoOficial::all();
        return view('admin.configuraciones.dias_festivos_no_oficiales', compact('diasFestivos'));
    }

    /**
     * crear|actualizar nuevo día festivo no oficial
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function agregarDiaFestivoNoOficial(Request $request)
    {
        $this->transformarMayusculas($request);

        $dia          = $request->get('dia');
        $celebracion  = $request->get('celebracion');
        $diaFestivoId = !empty($request->get('diaFestivoId')) ? (int)$request->get('diaFestivoId') : null;
        $respuesta    = ['estatus' => 'OK'];

        if (!is_null($diaFestivoId)) {
            $diaFestivoOficial = DiaFestivoNoOficial::find($diaFestivoId);

        } else {
            $diaFestivoOficial = new DiaFestivoNoOficial();

        }

        $diaFestivoOficial->asignarFecha($dia, $celebracion);

        try {
            $diaFestivoOficial->save();

        } catch (Exception $e) {
            $respuesta['estatus'] = 'fail';

            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

        } finally {
            return response()->json($respuesta);
        }
    }

    /**
     * buscar días festivos no oficiales
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function recargarDiasFestivosNoOficiales()
    {
        $respuesta         = ['estatus' => 'OK'];
        $diasFestivos      = DiaFestivoNoOficial::all();
        $respuesta['html'] = view('admin.configuraciones.dias_festivos_no_oficiales_tabla', compact('diasFestivos'))->render();

        return response()->json($respuesta);
    }

    /**
     * eliminar día festivo de la BD
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function eliminarDiaFestivoNoOficial(Request $request)
    {
        $diaFestivoId = (int)$request->get('diaFestivoId');
        $respuesta    = ['estatus' => 'OK'];

        try {
            DiaFestivoNoOficial::destroy($diaFestivoId);

        } catch (Exception $e) {
            $respuesta['estatus'] = 'fail';

            $pdoLogger = new SidepLogger(new Logger('pdo_exception'), new StreamHandler(storage_path() . '/logs/pdo/sqlsrv_' . date('Y-m-d') . '.log', Logger::ERROR));
            $pdoLogger->log($e);

        } finally {
            return response()->json($respuesta);
        }
    }
}