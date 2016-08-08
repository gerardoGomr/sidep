<?php
namespace Sidep\Http\Controllers\Admin\ServidoresPublicos;

use \DateTime;
use Sidep\Aplicacion\ColeccionArray;
use Sidep\Aplicacion\Reporte;
use Sidep\Aplicacion\Reportes\CartaCompromisoCrystalReports;
use Sidep\Aplicacion\Reportes\ComprobanteCuentaAccesoCrystalReports;
use Sidep\Aplicacion\TransformadorMayusculas;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\Declaracion;
use Sidep\Dominio\ServidoresPublicos\DeclaracionTipo;
use Sidep\Dominio\ServidoresPublicos\Domicilio;
use Sidep\Dominio\ServidoresPublicos\Encargo;
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
     * @param PuestosRepositorio $puestosRepositorio
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(PuestosRepositorio $puestosRepositorio)
    {
        $encargos = $this->encargosRepositorio->obtenerTodos();
        $puestos  = $puestosRepositorio->obtenerTodos();
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

        $encargos === null ? $respuesta['estatus'] = 'fail' : $respuesta['estatus'] = 'OK';

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
            $respuesta['estatus'] = 'fail';
        }

        // enviar correo al servidor público si tiene
        /*$mailer = new LaravelMailer('mails.encargo_alta', $encargo, 'ALTA DE ENCARGO');
        $mailer->enviar();*/
        // ================================================================================

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
        if (!$servidoresRepositorio->actualizar($servidor)) {
            $respuesta['estatus'] = 'fail';
        }

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
        $motivo    = $request->get('motivo');
        $fechaBaja = $request->get('fechaBaja');

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);

        // generar declaracion
        $declaracion = new Declaracion(DeclaracionTipo::CONCLUSION, new DateTime(), $encargo);

        // generar movimiento
        $movimiento = new Movimiento(MovimientoTipo::BAJA, DateTime::createFromFormat('d/m/Y', $fechaBaja), $encargo, $motivo);

        $encargo->baja($movimiento, $declaracion);

        // **********************************************************************
        // persistir encargo
        $respuesta['estatus'] = 'OK';

        if (!$this->encargosRepositorio->actualizar($encargo)) {
            $respuesta['estatus'] = 'fail';

            return response()->json($respuesta);
        }

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
        $encargoId   = (int)$request->get('encargoId');
        $adscripcion = $request->get('adscripcion');
        $respuesta   = [];

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);

        // generar movimiento de cambio de adscripción
        $movimiento = new Movimiento(MovimientoTipo::CAMBIO_ADSCRIPCION, new DateTime(), $encargo);

        if(!$encargo->cambiarAdscripcion($adscripcion, $movimiento)) {
            $respuesta['estatus'] = 'fail';
            $respuesta['error']     = 'LA ADSCRIPCIÓN ESPECIFICADA DEBE SER DIFERENTE A LA ACTUAL.';

            return response()->json($respuesta);
        }

        $respuesta['estatus'] = 'OK';

        if (!$this->encargosRepositorio->actualizar($encargo)) {
            $respuesta['estatus'] = 'fail';

            return response()->json($respuesta);
        }

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
        $encargoId   = (int)$request->get('encargoId');
        $puestoId    = (int)$request->get('puesto');
        $adscripcion = $request->get('adscripcion');
        $respuesta   = [];

        $encargo = $this->encargosRepositorio->obtenerPorId($encargoId);
        $puesto  = $puestosRepositorio->obtenerPorId($puestoId);

        // generar movimiento de cambio de adscripción
        $movimientoBaja = new Movimiento(MovimientoTipo::BAJA, new DateTime(), $encargo, MovimientoMotivo::PROMOCION);
        $movimientoAlta = new Movimiento(MovimientoTipo::ALTA, new DateTime(), $encargo, MovimientoMotivo::PROMOCION);

        // generar declaracion
        $declaracionConclusion = new Declaracion(DeclaracionTipo::CONCLUSION, new DateTime(), $encargo);
        $declaracionInicial    = new Declaracion(DeclaracionTipo::INICIAL, new DateTime(), $encargo);

        if(!$encargo->recibirPromocion($puesto, $adscripcion, $movimientoBaja, $movimientoAlta, $declaracionConclusion, $declaracionInicial)) {
            $respuesta['estatus'] = 'fail';
            return response()->json($respuesta);
        }

        if(!$this->encargosRepositorio->actualizar($encargo)) {
            $respuesta['estatus'] = 'fail';
            return response()->json($respuesta);
        }

        $respuesta['id']      = $encargo->getId();
        $respuesta['estatus'] = 'OK';
        $respuesta['html']    = view('admin.servidores_publicos.servidores_publicos_ficha', compact('encargo'))->render();

        return response()->json($respuesta);
    }
}