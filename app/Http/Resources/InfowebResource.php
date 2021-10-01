<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InfowebResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            //'etiquetas' => $this->etiquetas,
            'logo' => $this->logo, //categorias::where('id', $this->categorias)->get(),
            'favicon' =>$this->favicon,
            'redes' => $this->redes,
            'footer' => $this->footer,
        ];
    }
}
