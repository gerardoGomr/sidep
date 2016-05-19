<?php
namespace Sidep\Aplicacion;

use Illuminate\Http\Request;
use Sidep\Dominio\ServidoresPublicos\CuentaAcceso;
use Sidep\Dominio\ServidoresPublicos\EncargosRepositorio;

/**
 * Class LoguearEncargos
 * Clase Application Service
 * loguear a un encargo, perteneciente a un servidor publico
 * @package Sidep\Aplicacion
 * @author Gerardo Adrián Gómez Ruiz
 * @version 1.0
 */
class LoguearEncargos
{
    /**
     * @var EncargosRepositorio
     */
    private $encargosRepositorio;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Request
     */
    private $request;

    /**
     * LoguearEncargos constructor.
     * @param Request $request
     * @param EncargosRepositorio|null $encargosRepositorio
     */
    private function __construct(Request $request, EncargosRepositorio $encargosRepositorio = null)
    {
        $this->username            = $request->get('username');
        $this->password            = $request->get('password');
        $this->request             = $request;
        $this->encargosRepositorio = $encargosRepositorio;
    }

    /**
     * @param Request $request
     * @param EncargosRepositorio $encargosRepositorio
     * @return LoguearEncargos
     */
    public static function loguear(Request $request, EncargosRepositorio $encargosRepositorio)
    {
        return new self($request, $encargosRepositorio);
    }

    /**
     * @param Request $request
     * @return LoguearEncargos
     */
    public static function salir(Request $request)
    {
        return new self($request);
    }

    /**
     * @return bool
     */
    public function login()
    {
        if(!is_null($encargo = $this->encargosRepositorio->obtenerEncargoPorUsernameCuentaAcceso($this->username))) {
            if (!$encargo->login($this->password)) {
                return false;
            }

            $this->request->session()->put('encargo', $encargo);

            return true;
        }
    }

    /**
     * cerrar sesión
     */
    public function logout()
    {
        $this->request->session()->flush();
    }
}