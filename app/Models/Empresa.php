<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $fillable = [
        'razonSocial',
        'ruc',
        'direccion',
        'telefono',
        'correo',
        'slogan',
        'horario',
        'logo',
        
    ];
    
}
