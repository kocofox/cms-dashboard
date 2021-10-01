<?php

namespace App\Http\Controllers;

use App\Http\Resources\WebResource;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
   
    public function getAll(Request $request)
    {  
        $trabajos = Image::where('post_id', $request->id)->orderBy('id','desc')->get();   
        return new WebResource($trabajos);
    }
    public function eliminarImg(Image $image)
    {
        
        $imgdel = Str::replace(env('APP_URL'), '', $image->image_paath);
        File::delete($imgdel);
        $image->delete();
        
        return (new WebResource($image))->additional(['msg' => 'Trabajo eliminada correctamente']);
    }
}
