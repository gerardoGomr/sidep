<?php
namespace Sidep\Http\Controllers\Admin;

use Sidep\Http\Requests;
use Sidep\Http\Controllers\Controller;

/**
 * Class ServidoresPublicosController
 * @package Sidep\Http\Controllers\Admin
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class ServidoresPublicosController extends Controller
{
    public function index()
    {
        return view('admin.servidores_publicos.servidores_publicos');
    }
}
