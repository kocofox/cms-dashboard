<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarNoticiaRequest extends FormRequest
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
            'titulo' => 'required|unique:noticias,titulo,',
            'contenido' => 'required',
            'img' => 'required',
            'categoria_id' => 'required',
            'user_id' => 'required',
            'status' => '',
            'etiquetas' => '',
            'redes' => '',
            'otros' => '',
            
            
            
        ];
    }
}
