<?php
namespace Sidep\Http\Controllers\Admin\ServidoresPublicos;

use DateTime;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Sidep\Aplicacion\ColeccionArray;
use Sidep\Aplicacion\Reporte;
use Sidep\Aplicacion\Reportes\CartaCompromisoCrystalReports;
use Sidep\Aplicacion\Reportes\ComprobanteCuentaAccesoCrystalReports;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;
use Sidep\Dominio\ServidoresPublicos\Dependencia;
use Sidep\Dominio\ServidoresPublicos\Domicilio;
use Sidep\Dominio\ServidoresPublicos\Encargo;
use Sidep\Dominio\ServidoresPublicos\EstadoCivil;
use Sidep\Dominio\ServidoresPublicos\Movimiento;
use Sidep\Dominio\ServidoresPublicos\MovimientoMotivo;
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
use Sidep\Aplicacion\LaravelMailer;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Sidep\Exceptions\SidepLogger;
use Sidep\Jobs\GuardarAccionDeEncargo;

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
     * mostrar view de administración de servidores públicos
     * obtener los últimos 50 encargos generados
     * @param PuestosRepositorio $puestosRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PuestosRepositorio $puestosRepositorio)
    {
        $encargos = $this->encargosRepositorio->obtenerTodos();
        $puestos  = $puestosRepositorio->obtenerTodos();

        (new GuardarAccionDeEncargo('INGRESÓ A ADMINISTRACIÓN DE ENCARGOS', session('encargo')))->handle();

        return view('admin.servidores_publicos.servidores_publicos', compact('encargos', 'puestos'));
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

        (new GuardarAccionDeEncargo('INGRESÓ A ALTA DE NUEVO ENCARGO', session('encargo')))->handle();
        return view('admin.servidores_publicos.servidores_publicos_encargo_alta', compact('dependencias', 'puestos'));
    }

    /**
     * mostrar vista de importar excel para alta
     * @param DependenciasRepositorio $dependenciasRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function altaImportar(DependenciasRepositorio $dependenciasRepositorio)
    {
        $dependencias = $dependenciasRepositorio->obtenerTodos();
        (new GuardarAccionDeEncargo('INGRESÓ A ALTA DE ENCARGOS MEDIANTE ARCHIVO EXCEL', session('encargo')))->handle();
        return view('admin.servidores_publicos.servidores_publicos_encargo_alta_excel', compact('dependencias'));
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
        (new GuardarAccionDeEncargo("BUSCÓ A UN SERVIDOR PÚBLICO CON EL PARÁMETRO: {\"" . $request->get('dato') . "\"}", session('encargo')))->handle();
        $datoBusqueda = str_replace(' ', '', $request->get('dato'));
        $encargos     = $this->encargosRepositorio->obtenerEncargos($datoBusqueda);
        $origen       = $request->get('origen');
        $respuesta    = [];

        if (is_null($encargos)) {
            $respuesta['estatus'] = 'fail';
            return response()->json($respuesta);
        }

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
        $respuesta['estatus']   = 'OK';
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
        $this->transformarMayusculas($request);

        // logica de guardado de servidor - encargo - movimiento - declaración
        $exento             = $request->get('exento') === 'on' ? true : false;
        $idPuesto           = (int)$request->get('puesto');
        $idDependencia      = (int)$request->get('dependencia');
        $servidorRegistrado = (int)$request->get('servidorRegistrado');
        $respuesta          = [];
        // **********************************************************************
        if ($servidorRegistrado === 0) {
            // validar que el servidor público efectivamente no exista
            $servidor = $servidoresRepositorio->obtenerPorCurp($request->get('curp'));

            if (!is_null($servidor)) {
                $respuesta['estatus'] = 'fail';
                $respuesta['error']     = 'EL SERVIDOR PÚBLICO ESPECIFICADO YA ESTÁ REGISTRADO.';

                return response()->json($respuesta);
            }
            // ==================================================================================

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
        $respuesta['estatus'] = 'OK';

        if (!$this->encargosRepositorio->guardar($encargo)) {
            (new GuardarAccionDeEncargo('INTENTÓ DAR DE ALTA UN NUEVO ENCARGO DE SERVIDOR PÚBLICO CON FALLO: "[' . serialize($encargo) . ']"', session('encargo')))->handle();
            $respuesta['estatus'] = 'fail';
        }

        // enviar correo al servidor público si tiene
        $mailer = new LaravelMailer('mails.encargo_alta', $encargo, 'ALTA DE ENCARGO');
        $mailer->enviar();
        // ================================================================================

        (new GuardarAccionDeEncargo('DIÓ DE ALTA UN NUEVO ENCARGO DE SERVIDOR PÚBLICO: "[' . serialize($encargo) . ']"', session('encargo')))->handle();

        $respuesta['id']   = $encargo->getId();
        $respuesta['pass'] = $encargo->getCuentaAcceso()->getPrimerPassword();

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

        (new GuardarAccionDeEncargo('VISUALIZÓ EL DETALLE DE UN ENCARGO: "[' . serialize($encargo) . ']"', session('encargo')))->handle();

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

        if (is_null($servidor)) {
            $error = 'EL SERVIDOR PÚBLICO SOLICITADO AÚN NO ESTÁ REGISTRADO';
            return view('admin.errors.404', compact('error'));
        }

        (new GuardarAccionDeEncargo('INGRESÓ A EDITAR LOS DATOS DE UN SERVIDOR PÚBLICO: "[' . serialize($servidor) . ']"', session('encargo')))->handle();

        return view('admin.servidores_publicos.servidores_publicos_editar', compact('servidor'));
    }

    /**
     * actualizar datos del servidor público
     * @param FormEditarServidorPublico $request
     * @param ServidoresPublicosRepositorio $servidoresRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function actualizar(FormEditarServidorPublico $request, ServidoresPublicosRepositorio $servidoresRepositorio)
    {
        // transformar a mayúsculas
        $this->transformarMayusculas($request);

        $respuesta = [];
        $servidor  = $servidoresRepositorio->obtenerPorId((int)$request->get('idServidorPublico'));

        if (is_null($servidor)) {
            $error = 'EL SERVIDOR PÚBLICO SOLICITADO AÚN NO ESTÁ REGISTRADO';
            return redirect('admin.error')->with(['error' => $error]);
        }

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

        $respuesta['estatus'] = 'OK';

        // persistir cambios
        if (!$servidoresRepositorio->guardar($servidor)) {
            $respuesta['estatus'] = 'fail';
        }

        (new GuardarAccionDeEncargo('ACTUALIZÓ LOS DATOS DEL SERVIDOR PÚBLICO: "[' . serialize($servidor) . ']"', session('encargo')))->handle();

        return response()->json($respuesta);
    }

    /**
     * generar y mostrar en pantalla la carta compromiso del servidor público
     *
     * si el id de encargo no existe, no se genera reporte y se muestra una vista
     * de error a usuario
     *
     * @param string $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function cartaCompromiso($id)
    {
        $id                = (int)$id;
        $existenciaEncargo = $this->encargosRepositorio->existeEncargo($id);

        if (!$existenciaEncargo) {
            return view('errors.general');
        }

        $reporte = new Reporte(new CartaCompromisoCrystalReports($id));

        (new GuardarAccionDeEncargo('GENERÓ EL REPORTE DE CARTA COMPROMISO', session('encargo')))->handle();

        if ($reporte->existe()) {
            return response()->file($reporte->ruta());
        }

        if ($reporte->generar()) {
            return response()->file($reporte->ruta());
        }
    }

    /**
     * generar y mostrar en pantalla el comprobante de cuenta de acceso del encargo
     * del servidor público
     *
     * si el id de encargo no existe, no se genera reporte y se muestra una vista
     * de error a usuario
     *
     * @param string $id
     * @param string $password
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function comprobanteCuentaAcceso($id, $password)
    {
        $id       = (int)$id;
        $password = base64_decode($password);

        $existenciaEncargo = $this->encargosRepositorio->existeEncargo($id);

        if (!$existenciaEncargo) {
            return view('errors.general');
        }

        $reporte = new Reporte(new ComprobanteCuentaAccesoCrystalReports($id, $password));

        (new GuardarAccionDeEncargo('GENERÓ EL REPORTE DE COMPROBANTE DE CUENTA DE ACCESO', session('encargo')))->handle();

        if ($reporte->existe()) {
            return response()->file($reporte->ruta());
        }

        if ($reporte->generar()) {
            return response()->file($reporte->ruta());
        }
    }

    /**
     * registrar la baja de encargo del servidor público
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function bajaEncargo(Request $request)
    {
        // validar, se hace desde controller debido a que solamente se espera un campo
        $this->validate($request, [
            'motivo'    => 'required',
            'fechaBaja' => 'required|date_format:d/m/Y'
        ]);

        $respuesta = [];
        $encargoId = (int)$request->get('encargoId');
        $motivo    = (int)$request->get('motivo');
        $fechaBaja = $request->get('fechaBaja');

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);

        // generar declaracion
        $declaracion = new Declaracion(DeclaracionTipo::CONCLUSION, DateTime::createFromFormat('d/m/Y', $fechaBaja), $encargo);

        // generar movimiento
        $movimiento = new Movimiento(MovimientoTipo::BAJA, DateTime::createFromFormat('d/m/Y', $fechaBaja), $encargo, $motivo);

        $encargo->baja($movimiento, $declaracion);

        // **********************************************************************
        // persistir encargo
        $respuesta['estatus'] = 'OK';

        if (!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['estatus'] = 'fail';

            return response()->json($respuesta);
        }

        (new GuardarAccionDeEncargo('REGISTRÓ LA BAJA DEL ENCARGO: "[' . serialize($encargo) . ']"', session('encargo')))->handle();

        // enviar correo al servidor público si tiene
        /*$mailer = new LaravelMailer('mails.encargo_baja', $encargo, 'BAJA DE ENCARGO');
        $mailer->enviar($encargo);*/
        // ================================================================================

        $respuesta['html'] = view('admin.servidores_publicos.servidores_publicos_ficha', compact('encargo'))->render();
        return response()->json($respuesta);
    }

    /**
     * realizar el cambio de adscripción del encargo
     * se genera un nuevo movimiento de tipo cambio de adscripción
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     * @throws \Throwable
     */
    public function cambioAdscripcion(Request $request)
    {
        $this->transformarMayusculas($request);

        $encargoId   = (int)$request->get('encargoId');
        $adscripcion = $request->get('adscripcion');
        $respuesta   = [];

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);

        // generar movimiento de cambio de adscripción
        $movimiento = new Movimiento(MovimientoTipo::CAMBIO_ADSCRIPCION, new DateTime(), $encargo);

        if(!$encargo->cambiarAdscripcion($adscripcion, $movimiento)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['error']   = 'LA ADSCRIPCIÓN ESPECIFICADA DEBE SER DIFERENTE A LA ACTUAL.';

            return response()->json($respuesta);
        }

        $respuesta['estatus'] = 'OK';

        if (!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['estatus'] = 'fail';

            return response()->json($respuesta);
        }

        (new GuardarAccionDeEncargo('REGISTRÓ CAMBIO DE ADSCRIPCIÓN: "[' . serialize($encargo) . ']"', session('encargo')))->handle();

        $respuesta['html'] = view('admin.servidores_publicos.servidores_publicos_ficha', compact('encargo'))->render();
        return response()->json($respuesta);
    }

    /**
     * registrar una promoción al encargo del servidor público
     * @param Request $request
     * @param PuestosRepositorio $puestosRepositorio
     * @return \Illuminate\Http\JsonResponse
     */
    public function promocion(Request $request, PuestosRepositorio $puestosRepositorio)
    {
        $encargoId       = (int)$request->get('encargoId');
        $puestoId        = (int)$request->get('puesto');
        $adscripcion     = $request->get('adscripcion');
        $fechaMovimiento = $request->get('fechaMovimiento');
        $respuesta       = [];

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);
        $puesto  = $puestosRepositorio->obtenerPorId($puestoId);
        $fecha   = DateTime::createFromFormat('d/m/Y', $fechaMovimiento);

        // generar movimiento de alta y declaración inicial con la fecha enviada
        $movimientoAlta     = new Movimiento(MovimientoTipo::ALTA, $fecha, $encargo, MovimientoMotivo::PROMOCION);
        $declaracionInicial = new Declaracion(DeclaracionTipo::INICIAL, $fecha, $encargo);
        // fecha anterior 1 día menos - cadena
        $fechaAnterior = $encargo->obtenerFechaAnteriorAPromocion($fecha);

        // generar movimiento de baja y declaracion de conclusión con fecha 1 dia menos
        $movimientoBaja        = new Movimiento(MovimientoTipo::BAJA, DateTime::createFromFormat('d/m/Y', $fechaAnterior), $encargo, MovimientoMotivo::PROMOCION);
        $declaracionConclusion = new Declaracion(DeclaracionTipo::CONCLUSION, DateTime::createFromFormat('d/m/Y', $fechaAnterior), $encargo);

        // generar la promoción
        try {
            $encargo->recibirPromocion($puesto, $adscripcion, $movimientoBaja, $movimientoAlta, $declaracionConclusion, $declaracionInicial);

        } catch(Exception $e) {
            $respuesta['estatus'] = 'fail';
            $respuesta['error']   = $e->getMessage();

            return response()->json($respuesta);
        }

        if(!$this->encargosRepositorio->guardar($encargo)) {
            $respuesta['estatus'] = 'fail';
            return response()->json($respuesta);
        }

        (new GuardarAccionDeEncargo('REGISTRÓ UNA PROMOCIÓN: "[' . serialize($encargo) . ']"', session('encargo')))->handle();

        $respuesta['id']      = $encargo->getId();
        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.servidores_publicos.servidores_publicos_ficha', compact('encargo'))->render();

        return response()->json($respuesta);
    }

    /**
     * registrar un nuevo encargo mediante la importación de archivo en excel
     * @param Request $request
     * @param PuestosRepositorio $puestosRepositorio
     * @param DependenciasRepositorio $dependenciasRepositorio
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     * @throws \Throwable
     */
    public function registrarEncargoExcel(Request $request, PuestosRepositorio $puestosRepositorio, DependenciasRepositorio $dependenciasRepositorio)
    {
        if($request->hasFile('archivo')) {
            $path                  = $request->file('archivo')->getRealPath();
            $dependenciaId         = (int)$request->get('dependencia');
            $dependencia           = $dependenciasRepositorio->obtenerPorId($dependenciaId);
            $fechaAlta             = $request->get('fechaAlta');
            $servidoresSinImportar = [];
            $registrosProcesados   = 0;
            $registrosImportados   = 0;
            $registrosNoImportados = 0;

            Excel::load($path, function ($reader) use ($puestosRepositorio, $dependencia, $fechaAlta, &$servidoresSinImportar, &$registrosImportados, &$registrosNoImportados, &$registrosProcesados) {
                $excel     = $reader->getExcel();
                //$hoja      = $excel->setSheetByIndex(0);
                $maximoRow = $excel->setActiveSheetIndex(0)->getHighestRow();

                for ($row = 9; $row <= $maximoRow; $row++) {
                    // validar la primer columna, que sea curp
                    $curp        = $excel->getActiveSheet()->getCell("B$row")->getValue();
                    $nombre      = $excel->getActiveSheet()->getCell("C$row")->getValue();
                    $paterno     = $excel->getActiveSheet()->getCell("D$row")->getValue();
                    $materno     = $excel->getActiveSheet()->getCell("E$row")->getValue();
                    $puesto      = $excel->getActiveSheet()->getCell("F$row")->getValue();
                    $categoria   = $excel->getActiveSheet()->getCell("G$row")->getValue();
                    $adscripcion = $excel->getActiveSheet()->getCell("H$row")->getValue();
                    $movimiento  = $excel->getActiveSheet()->getCell("I$row")->getValue();
                    $calle       = $excel->getActiveSheet()->getCell("K$row")->getValue();
                    $num         = $excel->getActiveSheet()->getCell("L$row")->getValue();
                    $colonia     = $excel->getActiveSheet()->getCell("M$row")->getValue();
                    $cp          = $excel->getActiveSheet()->getCell("N$row")->getValue();
                    $municipio   = $excel->getActiveSheet()->getCell("O$row")->getValue();

                    if (trim($movimiento) === 'ALTA') {
                        // validar la curp en el sistema
                        $encargos = $this->encargosRepositorio->obtenerEncargos($curp);

                        if (is_null($encargos)) {
                            // buscar por nombre
                            $encargos = $this->encargosRepositorio->obtenerEncargos($nombre . $paterno . $materno);

                            if (is_null($encargos)) {
                                // es nuevo encargo
                                $servidorPublico = $this->crearServidor($nombre, $paterno, $materno, $curp, $calle, $num, $colonia, $cp, $municipio);

                                try {
                                    $encargo = $this->crearNuevoEncargo($servidorPublico, $categoria, $adscripcion, $dependencia, $puestosRepositorio);
                                    if (!$this->generarNuevoEncargo($encargo, $fechaAlta)) {
                                        $registrosNoImportados++;
                                    } else {
                                        $registrosImportados++;
                                    }

                                } catch (Exception $e) {
                                    // loguear el error
                                    $pdoLogger = new SidepLogger(new Logger('exception'), new StreamHandler(storage_path() . '/logs/exceptions/exc_' . date('Y-m-d') . '.log', Logger::ERROR));
                                    $pdoLogger->log($e);

                                    // meter a listado de los que no se pueden ingresar
                                    $datosDelServidor = [
                                        'nombre' => $nombre . ' ' . $paterno . ' ' . $materno,
                                        'curp'   => $curp
                                    ];

                                    $servidoresSinImportar[] = $datosDelServidor;
                                    $registrosNoImportados++;
                                }

                            } else {
                                // verificar el ultimo movimiento, en caso que tenga baja, reactivar
                                // si no es mov. de baja, rechazar
                                if (count($encargos) === 1) {
                                    $encargo = array_first($encargos);

                                    if ($encargo->elUltimoMovimientoEsBaja()) {
                                        if ($encargo->elUltimoMovimientoEsPorTerminoEncargo()) {
                                            if (!$this->generarNuevoEncargo($encargo, $fechaAlta)) {
                                                $registrosNoImportados++;
                                            } else {
                                                $registrosImportados++;
                                            }

                                        } else {
                                            // meter a listado de los que no se pueden ingresar
                                            $datosDelServidor = [
                                                'nombre' => $encargo->getServidorPublico()->nombreCompleto(),
                                                'curp'   => $encargo->getServidorPublico()->getCurp()
                                            ];

                                            $servidoresSinImportar[] = $datosDelServidor;
                                            $registrosNoImportados++;
                                        }
                                    } else {
                                        // meter a listado de los que no se pueden ingresar
                                        $datosDelServidor = [
                                            'nombre' => $encargo->getServidorPublico()->nombreCompleto(),
                                            'curp'   => $encargo->getServidorPublico()->getCurp()
                                        ];

                                        $servidoresSinImportar[] = $datosDelServidor;
                                        $registrosNoImportados++;
                                    }
                                } else {
                                    // meter a listado de los que no se pueden ingresar
                                    $datosDelServidor = [
                                        'nombre' => $nombre . ' ' . $paterno . ' ' . $materno,
                                        'curp'   => $curp
                                    ];

                                    $servidoresSinImportar[] = $datosDelServidor;
                                    $registrosNoImportados++;
                                }
                            }
                        } else {
                            // verificar el ultimo movimiento, en caso que tenga baja, reactivar
                            // si no es mov. de baja, rechazar
                            if (count($encargos) === 1) {
                                $encargo = array_first($encargos);

                                if ($encargo->elUltimoMovimientoEsBaja()) {
                                    if ($encargo->elUltimoMovimientoEsPorTerminoEncargo()) {
                                        if (!$this->generarNuevoEncargo($encargo, $fechaAlta)) {
                                            $registrosNoImportados++;
                                        } else {
                                            $registrosImportados++;
                                        }

                                    } else {
                                        // meter a listado de los que no se pueden ingresar
                                        $datosDelServidor = [
                                            'nombre' => $encargo->getServidorPublico()->nombreCompleto(),
                                            'curp'   => $encargo->getServidorPublico()->getCurp()
                                        ];

                                        $servidoresSinImportar[] = $datosDelServidor;
                                        $registrosNoImportados++;
                                    }
                                } else {
                                    // meter a listado de los que no se pueden ingresar
                                    $datosDelServidor = [
                                        'nombre' => $encargo->getServidorPublico()->nombreCompleto(),
                                        'curp'   => $encargo->getServidorPublico()->getCurp()
                                    ];

                                    $servidoresSinImportar[] = $datosDelServidor;
                                    $registrosNoImportados++;
                                }
                            } else {
                                // meter a listado de los que no se pueden ingresar
                                $datosDelServidor = [
                                    'nombre' => $nombre . ' ' . $paterno . ' ' . $materno,
                                    'curp'   => $curp
                                ];

                                $servidoresSinImportar[] = $datosDelServidor;
                                $registrosNoImportados++;
                            }
                        }
                    } else {
                        // meter a listado de los que no se pueden ingresar
                        $datosDelServidor = [
                            'nombre' => $nombre . ' ' . $paterno . ' ' . $materno,
                            'curp'   => $curp
                        ];

                        $servidoresSinImportar[] = $datosDelServidor;
                        $registrosNoImportados++;
                    }

                    $registrosProcesados++;
                }
            });

            return response()->json([
                'estatus' => 'OK',
                'html'    => view('admin.servidores_publicos.servidores_publicos_resultado_importacion', compact('servidoresSinImportar', 'registrosProcesados', 'registrosImportados', 'registrosNoImportados'))->render()
            ]);

        } else {
            return response()->json([
                'estatus' => 'fail',
                'mensaje' => 'EL ARCHIVO NO SE SUBIÓ AL SERVIDOR'
            ]);
        }
    }

    /**
     * crear un nuevo servidor publico
     * @param string $nombre
     * @param string $paterno
     * @param string $materno
     * @param string $curp
     * @param string $calle
     * @param string $numero
     * @param string $colonia
     * @param string $cp
     * @param string $municipio
     * @return ServidorPublico
     * @throws \Sidep\Dominio\Excepciones\EstadoCivilInvalidoException
     */
    private function crearServidor($nombre, $paterno, $materno, $curp, $calle, $numero, $colonia, $cp, $municipio)
    {
        // crear objeto servidor
        $servidor = new ServidorPublico();
        $servidor->registrar($nombre, $paterno, $materno, '', $curp, null, new Domicilio($calle, $numero, '', $colonia, $cp, $municipio ), EstadoCivil::SOLTERO, '', '');
        $servidor->obtenerFechaNacimientoEnBaseACurp();
        $servidor->obtenerRfcEnBaseACurp();

        return $servidor;
    }

    /**
     * crear nuevo encargo
     * @param ServidorPublico $servidor
     * @param string $categoria
     * @param string $adscripcion
     * @param Dependencia $dependencia
     * @param PuestosRepositorio $puestosRepositorio
     * @throws Exception
     * @return Encargo
     */
    private function crearNuevoEncargo(ServidorPublico $servidor, $categoria, $adscripcion, Dependencia $dependencia, PuestosRepositorio $puestosRepositorio)
    {
        // obtener puesto por id
        $puesto = $puestosRepositorio->obtenerPorNombre($categoria);

        if (is_null($puesto)) {
            throw new Exception('EL PUESTO ESPECIFICADO EN EL ARCHIVO NO EXISTE EN LA BASE DE DATOS');
        }

        return new Encargo($servidor, $adscripcion, new CuentaAcceso(), $puesto, $dependencia, new ColeccionArray(), new ColeccionArray());

    }

    /**
     * generar nuevo encargo
     * @param Encargo $encargo
     * @param string $fechaAlta
     * @return bool
     * @throws \Sidep\Dominio\Excepciones\NoEsDeclaracionInicialException
     * @throws \Sidep\Dominio\Excepciones\NoEsMovimientoDeAltaException
     */
    private function generarNuevoEncargo(Encargo $encargo, $fechaAlta)
    {
        // generar declaracion
        $declaracion = new Declaracion(DeclaracionTipo::INICIAL, new DateTime(), $encargo);

        // generar movimiento
        $movimiento = new Movimiento(MovimientoTipo::ALTA, new DateTime(), $encargo);

        // generar alta
        $encargo->alta(false, $movimiento, $declaracion, $fechaAlta);

        return $this->encargosRepositorio->guardar($encargo);
    }

    public function agregarServidorPublicoQueNoSeAgrega(array $servidoresSinImportar)
    {
        $servidoresSinImportar[] = [
            ''
        ];
    }
}