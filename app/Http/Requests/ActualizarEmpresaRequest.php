<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarEmpresaRequest extends FormRequest
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
            'razonSocial' => 'required|unique:empresas,razonSocial,'.$this->route('empresa')->id, //'required|unique:noticias,titulo,{$this->noticias->id}',
            'ruc' => 'required',
            'direccion' => 'required',
            'telefono' => 'required',
            'correo' => 'required',
            'slogan' => 'required',
            'horario' => 'required',
            'logo' => 'required',
            
        ];
    }
}
