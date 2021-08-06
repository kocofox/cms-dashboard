<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarUserRequest extends FormRequest
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
              //$this->route('noticia')->id, //'required|unique:noticias,titulo,{$this->noticias->id}',
            'name' => 'required|string|max:255',
            'fullname' => '',
            'profiles_id' => '',
            'avatar' => '', //categorias::where('id', $this->categorias)->get(),
            'email' => 'string|email|max:255|unique:users,email,'.$this->route('usuario')->id,
            'password' => 'string|min:6|confirmed',

        ];
    }
}
