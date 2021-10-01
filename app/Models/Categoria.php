<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
       
        
    ];
    public function noticias(){
        return $this->hasMany('App\Models\Noticia');

    }
    public function servicios(){
        return $this->hasMany('App\Models\Servicio');

    }
    public function trabajos(){
        return $this->hasMany('App\Models\Trabajo');

    }
}
