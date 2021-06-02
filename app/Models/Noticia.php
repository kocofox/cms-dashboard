<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'categoria_id',
        'titulo',
        'contenido',
        'img',
        'status',
        'etiquetas',
        'redes',
        'otros',
        
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');

    }
    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');

    }
}
