<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contacto extends Model
{
    use HasFactory;
    protected $fillable = [
        'razonSocial',
        'ruc',
        'correo',
        'direccion',
        'telefono',
        'asunto',
        'mensaje',


    ];
}
