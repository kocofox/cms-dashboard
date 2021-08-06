<?php

namespace App\Http\Resources;
use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticiahomeResource extends JsonResource
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
            'contenido' =>Str::limit( $this->contenido , 200, '...'),
            'img' => $this->img,
            'categoria' => $this->categoria,  //categorias::where('id', $this->categorias)->get(),
            'categorias_id' => $this->categoria_id,
            'etiquetas' => $this->etiquetas,
            'usuario' => $this->user,
        ];
    }
    
}
