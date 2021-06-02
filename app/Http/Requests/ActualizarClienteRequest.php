<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarClienteRequest extends FormRequest
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
            'razonSocial' => 'required|unique:clientes,razonSocial,' . $this->route('clientes')->id, //'required|unique:noticias,titulo,{$this->noticias->id}',
            'ruc' => 'required',
            'correo' => '',
            'direccion' => '',
            'telefono' => '',

            'correo' => '',
            'slogan' => '',
            'horario' => '',
            'logo' => '',


        ];
    }
}
