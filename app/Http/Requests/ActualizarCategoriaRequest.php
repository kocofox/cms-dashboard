<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarCategoriaRequest extends FormRequest
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
            'nombre' => 'required|unique:categorias,nombre,'.$this->route('categoria')->id, //'required|unique:noticias,titulo,{$this->noticias->id}',
            'descripcion' => '',
            'imagen' => '',
            
        ];
    }
}
