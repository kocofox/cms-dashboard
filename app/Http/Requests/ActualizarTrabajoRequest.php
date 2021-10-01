<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarTrabajoRequest extends FormRequest
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
            'id' => '',
            'nombre' => 'required|unique:trabajos,nombre,' . $this->route('trabajo')->id,
            'lugar' => '',
            'descripcion' => 'required',
            'categoria_id' => '',
            'imagen' => '',
            'imgs' => '',
            'images' => '',
        ];
    }
}
