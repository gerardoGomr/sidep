<?php

namespace Sidep\Http\Requests;

use Sidep\Http\Requests\Request;

class FormAltaRequest extends Request
{
    protected $rules = [
        'nombre'           => 'required',
        'paterno'          => 'required',
        'materno'          => 'required',
        'fechaNacimiento'  => 'required|date_format:d/m/Y',
        'curp'             => 'required|max:18|min:18',
        'rfc'              => 'required|max:10|min:10',
        'calle'            => 'required',
        'noExterior'       => 'required',
        'coloniaLocalidad' => 'required',
        'municipio'        => 'required',
        'dependencia'      => 'required',
        'puesto'           => 'required',
        'adscripcion'      => 'required',
        'fechaIngreso'     => 'required|date_format:d/m/Y'
    ];
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $servidorRegistrado = (int)$this->get('servidorRegistrado');
        $rules = $this->rules;

        if ($servidorRegistrado === 1) {
            // quitar la validación a elementos pertenecientes a servidor público
            $rules['nombre']           = '';
            $rules['paterno']          = '';
            $rules['materno']          = '';
            $rules['fechaNacimiento']  = '';
            $rules['curp']             = '';
            $rules['rfc']              = '';
            $rules['calle']            = '';
            $rules['noExterior']       = '';
            $rules['coloniaLocalidad'] = '';
            $rules['municipio']        = '';
        }

        return $rules;
    }

    public function response(array $errors)
    {
        return parent::response($errors); // TODO: Change the autogenerated stub
    }
}
