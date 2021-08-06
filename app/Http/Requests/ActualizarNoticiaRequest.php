<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarNoticiaRequest extends FormRequest
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
        $noticia = $this->route()->parameter('noticia');
        return [
            'titulo' => 'required|unique:noticias,titulo,'.$noticia->id,    //$this->route('noticia')->id, //'required|unique:noticias,titulo,{$this->noticias->id}',
            'contenido' => 'required',
            'img' => '',
            'user_id' => '',
            'categoria_id' => '',
            'status' => '',
            'etiquetas' => '',
            'redes' => '',
            'otros' => '',

        ];
    }
}
