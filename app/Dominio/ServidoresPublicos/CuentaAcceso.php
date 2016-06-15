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
     * @var array
     */
    private $letrasAAsignar = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

    /**
     * CuentaAcceso constructor.
     * @param string $username
     * @param string|null $password
     */
    public function __construct($username = null, $password = null)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
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

    /**
     * generar username y password de acceso a sistema al encargo
     * del servidor público. Se toma como base el RFC para el username y se concatena una letra aleatoria
     * y para el password se genera una cadea de 6 caracteres de manera aleatoria.
     * Se excluye la letra 'ñ'
     * @param string $rfc
     */
    public function generarCuentaDeAcceso($rfc)
    {
        // username
        $this->username = $rfc . $this->letrasAAsignar[rand(0, 25)];

        // generar password
        $digito1   = (string)rand(1, 9);
        $digito2   = (string)rand(1, 9);
        $digito3   = (string)rand(1, 9);
        $caracter1 = $this->letrasAAsignar[rand(0, 25)];
        $caracter2 = $this->letrasAAsignar[rand(0, 25)];
        $caracter3 = $this->letrasAAsignar[rand(0, 25)];

        // password
        $this->password = self::generarHash($caracter1 . $caracter2 . $caracter3 . $digito1 . $digito2 . $digito3);
    }
}