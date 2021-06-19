<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'fullname' => $this->fullname,
            'profiles_id' => $this->profiles_id,
            'profiles' => $this->profiles,
            'avatar' => $this->avatar, //categorias::where('id', $this->categorias)->get(),
            'email' => $this->email,
            
        ];
    }
    
}
