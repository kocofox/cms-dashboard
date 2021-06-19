<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicio extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'lugar',
        'descripcion',
        'categoria_id',
        'imagen',
        'imgs',
        
        
    ];
    public function getRouteKeyName()
    {
        return 'nombre';
    }
    public function resolveRouteBinding( $value, $field = NULL )
    {
        return $this->newQuery()
            ->when( is_numeric( $value ), 

                function ( $query ) use ( $value ) {
                    $query->where('id', $value );
                    
                }, 
                function ( $query ) use ( $value ) { // else
                    $query->where('nombre', $value );
                   
                } 
            )
            ->firstOrFail();
    }
    public function categoria(){
        return $this->belongsTo('App\Models\Categoria');

    }
}
