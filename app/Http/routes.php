<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
 * colección de rutas para la administración
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => ['usuarioC3Autenticado', 'menu']], function() {

        /**
         * ruta para mostrar la vista principal
         */
        Route::get('/', function () {
            return view('admin.principal');
        });

        /**
         * ruta para mostrar la vista de administración de encargos
         */
        Route::get('servidores', 'Admin\ServidoresPublicos\ServidoresPublicosController@index');

        /**
         * ruta para mostrar la vista de alta de encargo de servidor público
         */
        Route::get('servidores/alta', 'Admin\ServidoresPublicos\ServidoresPublicosController@alta');

        /**
         * ruta para mostrar la vista de alta de encargo de servidor público
         */
        Route::get('servidores/alta/importar', 'Admin\ServidoresPublicos\ServidoresPublicosController@altaImportar');

        /**
         * ruta para buscar a servidores públicos
         */
        Route::post('servidores/busqueda',[
            'as'   => 'servidores-busqueda',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@busqueda'
        ]);

        /**
         * ruta para guardar encargos alta mediante excel
         */
        Route::post('servidores/alta/excel', [
            'as'   => 'servidores-encargo-alta-excel',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@registrarEncargoExcel'
        ]);

        /**
         * ruta para guardar el nuevo encargo del servidor público
         */
        Route::post('servidores/alta',[
            'as'   => 'servidores-encargo-alta',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@registrarEncargo'
        ]);

        /**
         * ruta para ver el detalle
         */
        Route::post('servidores/detalle', [
            'as'   => 'servidores-detalle',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@detalle'
        ]);

        /**
         * ruta para mostrar la vista de edición de datos personales del servidor público
         */
        Route::get('servidores/editar/{id?}', 'Admin\ServidoresPublicos\ServidoresPublicosController@editarDatos');

        /**
         * ruta para guardar los cambios generados al servidor público
         */
        Route::post('servidores/editar', [
            'as'   => 'servidores-editar',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@actualizar'
        ]);

        /**
         * ruta para generar carta compromiso
         */
        Route::get('servidores/carta-compromiso/{id}', 'Admin\ServidoresPublicos\ServidoresPublicosController@cartaCompromiso');

        /**
         * ruta para generar comprobante cuenta de acceso
         */
        Route::get('servidores/comprobante-cuenta-acceso/{id}/{pass}', 'Admin\ServidoresPublicos\ServidoresPublicosController@comprobanteCuentaAcceso');

        /**
         * ruta para generar la baja del encargo especificado
         */
        Route::post('servidores/encargo/baja', [
            'as'   => 'encargo-baja',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@bajaEncargo'
        ]);

        /**
         * ruta para actualizar la adscripción del servidor público
         */
        Route::post('servidores/encargo/cambio-adscripcion', [
            'as'   => 'encargo-cambio-adscripcion',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@cambioAdscripcion'
        ]);

        /**
         * ruta para realizar una promoción
         */
        Route::post('servidores/encargo/promocion', [
            'as'   => 'encargo-promocion',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@promocion'
        ]);

        /**
         * ruta para visualizar el historial de movimientos
         */
        Route::get('consultas/reporte-del-dia', 'Admin\Consultas\ConsultasController@reporteDelDia');

        /**
         * ruta para buscar dentro del historial
         */
        Route::post('consultas/reporte-del-dia/buscar', [
            'as'   => 'reporte-del-dia-buscar',
            'uses' => 'Admin\Consultas\ConsultasController@buscarMovimientosDia'
        ]);

        /**
         * ruta para exportar historial
         */
        Route::post('consultas/reporte-del-dia/exportar', [
            'as'   => 'reporte-del-dia-exportar',
            'uses' => 'Admin\Consultas\ConsultasController@exportarMovimientosDia'
        ]);

        /**
         * ruta para mostrar las declaraciones que no se han realizado
         */
        Route::get('consultas/declaraciones/no-realizadas', 'Admin\Consultas\ConsultasController@declaracionesNoRealizadas');

        /**
         * ruta para buscar declaraciones no realizadas
         */
        Route::post('consultas/declaraciones/no-realizadas/buscar', [
            'as'   => 'declaraciones-no-realizadas-buscar',
            'uses' => 'Admin\Consultas\ConsultasController@buscarDeclaracionesNoRealizadas'
        ]);

        /**
         * ruta para exportar las declaraciones no realizadas
         */
        Route::post('consultas/declaraciones/no-realizadas/exportar', [
            'as'   => 'declaraciones-no-realizadas-exportar',
            'uses' => 'Admin\Consultas\ConsultasController@exportarDeclaracionesNoRealizadas'
        ]);

        /**
         * ruta para mostrar las declaraciones que ya se han realizado
         */
        Route::get('consultas/declaraciones/realizadas', 'Admin\Consultas\ConsultasController@declaracionesRealizadas');

        /**
         * ruta para buscar declaraciones realizadas
         */
        Route::post('consultas/declaraciones/realizadas/buscar', [
            'as'   => 'declaraciones-realizadas-buscar',
            'uses' => 'Admin\Consultas\ConsultasController@declaracionesRealizadasBuscar'
        ]);

        /**
         * ruta para exportar declaraciones realizadas
         */
        Route::post('consultas/declaraciones/realizadas/exportar', [
            'as'   => 'declaraciones-realizadas-exportar',
            'uses' => 'Admin\Consultas\ConsultasController@declaracionesRealizadasExportar'
        ]);

        /**
         * ruta para generar la vista de los omisos
         */
        Route::get('consultas/declaraciones/omisos', 'Admin\Consultas\ConsultasController@omisos');

        /**
         * ruta para generar la vista de desmarcar omisos
         */
        Route::get('consultas/declaraciones/omisos-desmarcar', 'Admin\Consultas\ConsultasController@desmarcarOmisosMostrar');

        /**
         * ruta para buscar a omisos con requerimientos activados
         */
        Route::post('consultas/declaraciones/omisos-desmarcar/buscar', [
            'as'   => 'omisos-desmarcar-buscar',
            'uses' => 'Admin\Consultas\ConsultasController@desmarcarOmisosBuscar'
        ]);

        /**
         * ruta para buscar omisos
         */
        Route::post('consultas/declaraciones/omisos/buscar', [
            'as'   => 'omisos-buscar',
            'uses' => 'Admin\Consultas\ConsultasController@buscarOmisos'
        ]);

        /**
         * ruta para marcar a los omisos
         */
        Route::post('consultas/declaraciones/omisos/marcar', [
            'as'   => 'omisos-marcar',
            'uses' => 'Admin\Consultas\ConsultasController@marcarOmisos'
        ]);

        /**
         * ruta para desmarcar a los omisos marcados
         */
        Route::post('consultas/declaraciones/omisos-desmarcar', [
            'as'   => 'omisos-desmarcar',
            'uses' => 'Admin\Consultas\ConsultasController@desmarcarOmisos'
        ]);

        /**
         * ruta para generar la vista de los requerimientos
         */
        Route::get('declaraciones/requerimientos', 'Admin\Declaraciones\DeclaracionesController@requerimientos');

        /**
         * ruta para generar el pdf de los requerimientos
         */
        Route::get('declaraciones/requerimientos/pdf/{declaracionId}', 'Admin\Declaraciones\DeclaracionesController@requerimientoPdf');

        /**
         * ruta para buscar requerimientos
         */
        Route::post('declaraciones/requerimientos/buscar', [
            'as'   => 'requerimientos-buscar',
            'uses' => 'Admin\Declaraciones\Declaracionescontroller@requerimientosBuscar'
        ]);

        /**
         * ruta para eliminar el requerimiento
         */
        Route::post('declaraciones/requerimientos', [
            'as'   => 'requerimiento-eliminar',
            'uses' => 'Admin\Declaraciones\Declaracionescontroller@requerimientoEliminar'
        ]);

        /**
         * ruta para generar la vista del retorno de requerimientos
         */
        Route::get('declaraciones/requerimientos/retorno', 'Admin\Declaraciones\DeclaracionesController@retornoRequerimientos');

        /**
         * ruta para buscar a las declaraciones que tienen requerimientos activos
         */
        Route::post('declaraciones/requerimientos/retorno/buscar', [
            'as'   => 'requerimientos-retorno-buscar',
            'uses' => 'Admin\Declaraciones\DeclaracionesController@retornoRequerimientosBuscar'
        ]);

        /**
         * ruta para marcar el retorno de las declaraciones que tiene requerimientos activos
         */
        Route::post('declaraciones/requerimientos/retorno/marcar', [
            'as'   => 'requerimientos-retorno-marcar',
            'uses' => 'Admin\Declaraciones\DeclaracionesController@retornoRequerimientosMarcar'
        ]);

        /**
         * ruta para generar la vista de la desmarcación de retorno de requerimientos
         */
        Route::get('declaraciones/requerimientos/desmarcar', 'Admin\Declaraciones\DeclaracionesController@requerimientosDesmarcarMostrar');

        /**
         * ruta para buscar a declaraciones que tienen requerimientos marcados de retorno
         */
        Route::post('declaraciones/requerimientos/desmarcar/buscar', [
            'as'   => 'requerimientos-desmarcar-buscar',
            'uses' => 'Admin\Declaraciones\Declaracionescontroller@requerimientosDesmarcarBuscar'
        ]);

        /**
         * ruta para desmarcar la recepción de requerimientos
         */
        Route::post('declaraciones/requerimientos/desmarcar', [
            'as'   => 'requerimientos-desmarcar',
            'uses' => 'Admin\Declaraciones\Declaracionescontroller@requerimientosDesmarcar'
        ]);

        /**
         * ruta para mostrar la vista de envíos a SFP
         */
        Route::get('declaraciones/envios-sfp/marcar', 'Admin\Declaraciones\DeclaracionesController@mostrarMarcarEnviosSFP');

        /**
         * ruta para buscar enviados a sfp
         */
        Route::post('declaraciones/envios-sfp/marcar-buscar', [
            'as'   => 'envios-sfp-marcar-buscar',
            'uses' => 'Admin\Declaraciones\DeclaracionesController@enviosSFPBuscar'
        ]);

        /**
         * ruta para marcar a las declaraciones como enviadas a SFP
         */
        Route::post('declaraciones/envios-sfp/marcar', [
            'as'   => 'enviados-sfp-marcar',
            'uses' => 'Admin\Declaraciones\DeclaracionesController@marcarEnviosSFP'
        ]);

        /**
         * ruta para mostrar la vista de los que ya fueron enviados a SFP
         */
        Route::get('declaraciones/enviados-sfp', 'Admin\Declaraciones\DeclaracionesController@mostrarEnviadosASFP');

        /**
         * ruta para buscar enviados a sfp
         */
        Route::post('declaraciones/enviados-sfp/marcar-buscar', [
            'as'   => 'enviados-sfp-marcar-buscar',
            'uses' => 'Admin\Declaraciones\DeclaracionesController@enviadosSFPBuscar'
        ]);

        /**
         * ruta para eliminar la sanción
         */
        Route::post('declaraciones/enviados-sfp/sancion-eliminar', [
            'as'   => 'sancion-eliminar',
            'uses' => 'Admin\Declaraciones\DeclaracionesController@enviadosSFPEliminar'
        ]);

        /**
         * ruta para generar la sanción en PDF
         */
        Route::get('declaraciones/enviados-sfp/pdf/{declaracionId}', 'Admin\Declaraciones\Declaracionescontroller@envioSancionPDF');

        /**
         * ruta para generar la vista de reportes de modificacion
         */
        Route::get('reportes/reporte-modificacion', 'Admin\Reportes\ReportesController@reporteModificacion');

        /**
         * ruta para generar la vista de usuarios
         */
        Route::get('usuarios', 'Admin\Usuarios\UsuariosController@index');

        /**
         * ruta para generar usuario
         */
        Route::post('usuarios/nuevo', 'Admin\Usuarios\UsuariosController@generar');

        /**
         * ruta para generar la vista de usuarios
         */
        Route::post('usuarios', 'Admin\Usuarios\UsuariosController@buscar');

        /**
         * ruta para generar el form de privilegios
         */
        Route::post('usuarios/privilegios/editar', 'Admin\Usuarios\UsuariosController@generarVistaPrivilegios');

        /**
         * ruta para asignar privilegios
         */
        Route::post('usuarios/privilegios', 'Admin\Usuarios\UsuariosController@asignarPrivilegios');
    });

    /**
     * ruta para mostrar la vista de login
     */
    Route::get('login', function(){
        return view('admin.login');
    });

    /**
     * ruta para procesar el login
     */
    Route::post('login', 'LoginController@login');

    /**
     * ruta para cerrar la sesión de usuario
     */
    Route::get('logout', 'LoginController@logout');
});

/**
 * Colección de rutas para los declarantes
 * @version 1.0
 */
Route::group(['prefix' => 'declarantes'], function() {
    Route::get('/', function () {
        return view('declarantes.principal');
    });

    Route::get('cuenta/nueva-contrasenia', function() {
        return view('declarantes.cuentas.recuperar_contrasenia');
    });
});

// login
Route::get('login', function(){
    return view('login');
});