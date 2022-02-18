<?php

namespace App\Http\Controllers;

use App\Http\Resources\WebResource;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ImagenController extends Controller
{
   
    public function getAll($url,  $request)
    {  
        
        switch ($url) {
            case "noticias":
                $tipo = "noticia_id";
              break;
            case "servicios":
                $tipo = "servicio_id";
              break;
            case "trabajos":
                $tipo = "trabajo_id";
              break;
          }

        $trabajos = Image::where($tipo, $request)->orderBy('id','asc')->get();   
        return new WebResource($trabajos);
    }
   
    public function eliminarImg($id)
    {
        $imagendel = Image::find($id);
       
      $imgdel = Str::replace(env('APP_URL'), '', $imagendel->image_path);
        File::delete($imgdel);
       $imagendel->delete();
        
        return (new WebResource($imagendel))->additional(['msg' => 'Imagen eliminada', $imagendel]);
    }
}
