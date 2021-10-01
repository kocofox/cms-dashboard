<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $fillable = [
        'post_id',
        'image_path',
        'image_caption',
       
        
    ];
    public function noticias(){
        return $this->belongsTo('App\Models\Noticia');

    }
    public function servicios(){
        return $this->belongsTo('App\Models\Servicio');

    }
    public function trabajos(){
        return $this->belongsTo('App\Models\Trabajo');

    }
}
