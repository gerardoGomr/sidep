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

// rutas protegidas

Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => ['usuarioC3Autenticado']], function() {
        Route::get('/', function () {
            return view('welcome');
        });
    });

    // login
    Route::get('login', function(){
        return view('admin.login');
    });

    // realizar login
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout');
});

// login
Route::get('login', function(){
    return view('login');
});