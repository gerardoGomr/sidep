<?php
namespace Sidep\Dominio\ServidoresPublicos;

/**
 * Class CuentaAcceso
 * @package Sidep\Dominio\ServidoresPublicos
 * @author Gerardo Adrián Gómez Ruiz
 * @version 2.0
 */
class CuentaAcceso
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * CuentaAcceso constructor.
     * @param string $username
     * @param string|null $password
     */
    public function __construct($username, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * comparar password
     * @param string $password
     * @return bool
     */
    public function login($password)
    {
        if (password_verify($password, $this->password)) {
            return true;
        }

        return false;
    }

    /**
     * genera una cadena y la devuelve con hash
     * @param $string
     * @return bool|false|string
     */
    public static function generarHash($string)
    {
        return password_hash($string, PASSWORD_DEFAULT);
    }
}