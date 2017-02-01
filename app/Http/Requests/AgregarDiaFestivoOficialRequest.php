<?php

namespace Sidep\Http\Requests;

use Sidep\Http\Requests\Request;

class AgregarDiaFestivoOficialRequest extends Request
{
    /**
     * @var array
     */
    private $rules = [
        'dia'         => 'required|numeric',
        'mes'         => 'required',
        'celebracion' => 'required'
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
        return $this->rules;
    }
}
