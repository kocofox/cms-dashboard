<?php

namespace App\Http\Resources;
use App\Http\Resources\WebResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ServicioResource extends JsonResource
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
            'nombre' => $this->nombre,
            'lugar' => $this->lugar,
            'descripcion' => $this->descripcion,
            'categoria_id' => $this->categoria_id,
            'categorias' => $this->categoria, //categorias::where('id', $this->categorias)->get(),
            'imagen' => $this->imagen,
            'imgs' => $this->imgs,
            
        ];
    }
    
}
