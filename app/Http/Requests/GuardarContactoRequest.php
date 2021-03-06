<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarContactoRequest extends FormRequest
{
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
        return [
            'razonSocial' => 'required',
            'ruc' => 'required',
            'correo' => 'required',
            'direccion' => '',
            'telefono' => 'required',
            'imagen' => '',
            'asunto' => 'required',
            'mensaje' => 'required',
            
            
        ];
    }
}
