<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarTrabajoRequest;
use App\Http\Requests\GuardarTrabajoRequest;
use App\Http\Resources\WebResource;
use App\Http\Resources\TrabajoResource;
use App\Models\Trabajo;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TrabajoResource::collection(Trabajo::paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarTrabajoRequest $request)
    { 
        $request->validated();
        $trabajo = new Trabajo();
        $trabajo->nombre = $request->input('nombre');
        $trabajo->lugar = $request->input('lugar');
        $trabajo->descripcion = $request->input('descripcion');
        $trabajo->categoria_id = $request->input('categoria_id');      
        $trabajo->save();
        $pics= $request->images;
      
         foreach($pics as $imgg) {
             $img = new Image();
             $img->image_caption =  $trabajo->nombre;
             $img->image_path = $this->upload($imgg);
             $img->post_id = $trabajo->id;
             $img->save();
        }
          return (new TrabajoResource($trabajo))->additional(['msg' => 'Trabajo agregada correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Trabajo $trabajo)
    { 
        return new TrabajoResource($trabajo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarTrabajoRequest $request, Trabajo $trabajo)
    {
        $trabajodel = $trabajo->imagen;
        
        
        $text = json_decode($request->imgs);

        $trabajo->update($request->all());
        $trabajo->update(
            [
                'imgs' => $text
            ]
        );
        if ($request->file('imagen')) {
            $url_image = $this->upload($request->file('imagen'));
            if ($trabajo->imagen) {
                $img = Str::replace(env('APP_URL'), '', $trabajodel);
                File::delete($img);
                $trabajo->update(
                    [
                        'imagen' =>  $url_image
                    ]
                );
            } else {
                $trabajo->created([
                    'imagen' => $url_image
                ]);
            }
        } else {
            $trabajo->update(
                [
                    'imagen' => $trabajodel

                ]
            );
        }


      
        return (new TrabajoResource($trabajo))->additional(['msg' => 'Trabajo actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Trabajo $trabajo)
    {
        $imgdel = Str::replace(env('APP_URL'), '', $trabajo->imagen);
        File::delete($imgdel);
        $trabajo->delete();
        
        return (new WebResource($trabajo))->additional(['msg' => 'Trabajo eliminada correctamente']);
    }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/trabajos';

        $rename = uniqid() . '-' . $name . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL') . "$post_path/$rename";
    }
    
}