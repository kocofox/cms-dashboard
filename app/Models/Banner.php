<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $fillable = [
        'alt',
        'url',
        'urls',
                
    ];
    protected $casts = [
        'urls'=> 'array'
        
    ];
}
