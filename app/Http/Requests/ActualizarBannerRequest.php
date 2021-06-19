<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarBannerRequest extends FormRequest
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
            'alt' => 'required|unique:banners,alt,' . $this->route('banner')->id,
            'url' => 'required',
            'urls' => '',
            'link' => '',
            'descripcion' => '',
        ];
    }
}
