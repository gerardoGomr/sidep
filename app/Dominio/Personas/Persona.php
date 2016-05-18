<?php
namespace Sidep\Dominio\Personas;

/**
* @author Gerardo Adrián Gómez Ruiz
*/
abstract class Persona
{
	/**
	 * nombre de persona
	 * @var string
	 */
	protected $nombre;

	/**
	 * apellido paterno de persona
	 * @var string
	 */
	protected $paterno;

	/**
	 * apellido materno de persona
	 * @var string
	 */
	protected $materno;

    /**
     * el sexo de la persona
     * @var string
     */
    protected $sexo;

    /**
     * telefono de la persona
     * @var string
     */
    protected $telefono;

    /**
     * celular de la persona
     * @var string
     */
    protected $celular;

    /**
     * correo de la persona
     * @var string
     */
    protected $email;

    const MASCULINO = 'M';

    const FEMENINO  = 'F';

	public function __construct($nombre = '', $paterno = '', $materno = '')
	{
        $this->nombre  = $nombre;
        $this->paterno = $paterno;
        $this->materno = $materno;
	}

	/**
     * Gets the nombre del funcionario.
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Sets the nombre del funcionario.
     *
     * @param string $nombre the nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    /**
     * Gets the apellido paterno del funcionario.
     *
     * @return string
     */
    public function getPaterno()
    {
        return $this->paterno;
    }

    /**
     * Sets the apellido paterno del funcionario.
     *
     * @param string $paterno the paterno
     */
    public function setPaterno($paterno)
    {
        $this->paterno = $paterno;
    }

    /**
     * Gets the apellido materno del funcionario.
     *
     * @return string
     */
    public function getMaterno()
    {
        return $this->materno;
    }

    /**
     * Sets the apellido materno del funcionario.
     *
     * @param string $materno the materno
     */
    public function setMaterno($materno)
    {
        $this->materno = $materno;
    }

    /**
     * obtener el nombre completo del funcionario
     * @return string
     */
    abstract public function nombreCompleto();

    /**
     * Gets the el sexo de la persona.
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
    }

    /**
     * Sets the el sexo de la persona.
     *
     * @param string $sexo the sexo
     */
    public function setSexo($sexo)
    {
        if(is_integer($sexo)) {
            $sexo = (string)$sexo;
        }

        switch ($sexo) {
            case '1':
                $this->sexo = self::MASCULINO;
                break;

            case '0':
                $this->sexo = self::FEMENINO;
                break;

            default:
                $this->sexo = $sexo;
                break;
        }
    }

    /**
     * Gets the telefono de la persona.
     *
     * @return string
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Sets the telefono de la persona.
     *
     * @param string $telefono the telefono
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    /**
     * Gets the celular de la persona.
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
    }

    /**
     * Sets the celular de la persona.
     *
     * @param string $celular the celular
     */
    public function setCelular($celular)
    {
        $this->celular = $celular;
    }

    /**
     * Gets the correo de la persona.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the correo de la persona.
     *
     * @param string $email the email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
}