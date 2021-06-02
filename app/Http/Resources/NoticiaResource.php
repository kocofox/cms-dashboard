<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NoticiaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'img' => $this->img,
            'categorias' => $this->categoria, //categorias::where('id', $this->categorias)->get(),
            'etiquetas' => $this->etiquetas,
            'redes' => $this->redes,
            'otros' => $this->otros,
            'Usuario' => $this->user,
        ];
    }
    
}
