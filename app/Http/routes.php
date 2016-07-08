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
 * colección de rutas del sistema
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => ['usuarioC3Autenticado']], function() {

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
         * ruta para buscar a servidores públicos
         */
        Route::post('servidores/busqueda',[
            'as'   => 'servidores-busqueda',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@busqueda'
        ]);

        /**
         * ruta para guardar el nuevo encargo del servidor público
         */
        Route::post('servidores/alta',[
            'as'   => 'servidores-encargo-alta',
            'uses' => 'Admin\ServidoresPublicos\ServidoresPublicosController@registrarEncargo'
        ]);

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

// login
Route::get('login', function(){
    return view('login');
});