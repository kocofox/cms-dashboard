<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Web extends Model
{
   // use HasFactory;
    
    
    protected $fillable = [
        'titulo',
        'descripcion',
        'logo',
        'favicon',
        'nosotros',
        'mision',
        'vision',
        'redes',
        'etiquetas',
        'footer',
    ];
    protected $casts = [
        'redes'=> 'array',
        'footer'=> 'array',
        'etiquetas'=> 'array'
    ];
}
