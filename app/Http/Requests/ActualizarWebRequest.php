<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarWebRequest extends FormRequest
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
            //
            'titulo' => 'required|unique:webs,titulo,'.$this->route('web')->id,
            'descripcion' => 'required',
            'etiquetas' => '',
            'logo' => '',
            'favicon' => '',
            'redes' => 'required',
            'nosotros' => 'required',
            'mision' => 'required',
            'vision' => 'required',
            'footer' => 'required ',
        ];
    }
}
