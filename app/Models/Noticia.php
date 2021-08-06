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
    protected $casts = [
        'redes' => 'array',
        'etiquetas' => 'array',
        'otros' => 'array'
    ];
    public function getRouteKeyName()
    {
        return 'titulo';
    }
    public function resolveRouteBinding( $value, $field = NULL )
    {
        return $this->newQuery()
            ->when( is_numeric( $value ), 

                function ( $query ) use ( $value ) {
                    $query->where('id', $value );
                    
                }, 
                function ( $query ) use ( $value ) { // else
                    $query->where('titulo', $value );
                   
                } 
            )
            ->firstOrFail();
    }
    
public function categoria()
    {
        return $this->belongsTo('App\Models\Categoria');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    
}
