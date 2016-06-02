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
     * Gets the apellido paterno del funcionario.
     *
     * @return string
     */
    public function getPaterno()
    {
        return $this->paterno;
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
     * Gets the el sexo de la persona.
     *
     * @return string
     */
    public function getSexo()
    {
        return $this->sexo;
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
     * Gets the celular de la persona.
     *
     * @return string
     */
    public function getCelular()
    {
        return $this->celular;
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
     * obtener el nombre completo del funcionario
     * @return string
     */
    public function nombreCompleto()
    {
        // TODO: Implement nombreCompleto() method.
        $nombre = $this->nombre;

        if (strlen($this->paterno)) {
            $nombre .= ' ' . $this->paterno;
        }

        if (strlen($this->materno)) {
            $nombre .= ' ' . $this->materno;
        }

        return $nombre;
    }
}