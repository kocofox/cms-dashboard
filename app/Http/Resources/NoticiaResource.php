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
            'id' => $this->id,
            'titulo' => $this->titulo,
            'contenido' => $this->contenido,
            'img' => $this->img,
            'categoria' => $this->categoria, //categorias::where('id', $this->categorias)->get(),
            'categoria_id' => $this->categoria_id,
            'etiquetas' => $this->etiquetas,
            'redes' => $this->redes,
            'otros' => $this->categori,
            'usuario' => $this->user,
        ];
    }
    
}
