<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarServicioRequest;
use App\Http\Requests\GuardarServicioRequest;
use App\Http\Resources\WebResource;
use App\Http\Resources\ServicioResource;
use App\Models\Servicio;
use App\Models\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ServicioResource::collection(Servicio::orderBy('id', 'desc')->paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarServicioRequest $request)
    {
        $request->validated();


        $servicio = new Servicio();

        $url_image = $this->upload($request->file('imagen'));
        $servicio->imagen = $url_image;
        $servicio->nombre = $request->input('nombre');
        $servicio->imgs = json_decode($request->input('imgs'));
        $servicio->lugar = $request->input('lugar');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->categoria_id = $request->input('categoria_id');

        $servicio->save();
        if ($request->images) {

            $pics = $request->images;

            foreach ($pics as $imgg) {
                $img = new Image();
                $img->image_caption =  $servicio->nombre;
                $img->image_path = $this->upload($imgg);
                $img->servicio_id = $servicio->id;
                $img->save();
            };
        }

        return (new ServicioResource($servicio))->additional(['msg' => 'Servicio agregada correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)

    {

        return new ServicioResource($servicio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarServicioRequest $request, Servicio $servicio)
    {
        $serviciodel = $servicio->imagen;


        $text = json_decode($request->imgs);

        if ($request->file('images')) {
            $pics = $request->images;

            foreach ($pics as $imgg) {
                $img = new Image();
                $img->image_caption =  $servicio->nombre;
                $img->image_path = $this->upload($imgg);
                $img->servicio_id = $servicio->id;
                $img->save();
            };
        }

        $servicio->update($request->all());
        $servicio->update(
            [
                'imgs' => $text
            ]
        );
        if ($request->file('imagen')) {
            $url_image = $this->upload($request->file('imagen'));
            if ($servicio->imagen) {
                $img = Str::replace(env('APP_URL'), '', $serviciodel);
                File::delete($img);
                $servicio->update(
                    [
                        'imagen' =>  $url_image
                    ]
                );
            } else {
                $servicio->created([
                    'imagen' => $url_image
                ]);
            }
        } else {
            $servicio->update(
                [
                    'imagen' => $serviciodel

                ]
            );
        }



        return (new ServicioResource($servicio))->additional(['msg' => 'Servicio actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        $imgdel = Str::replace(env('APP_URL'), '', $servicio->imagen);
        File::delete($imgdel);
        $servicio->delete();

        return (new WebResource($servicio))->additional(['msg' => 'Servicio eliminada correctamente']);
    }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/servicios';

        $rename = uniqid() . '-' . $name . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL') . "$post_path/$rename";
    }
    private function imagenes($pics, $idTrab)
    {
        foreach ($pics as $imgg) {
            $img = new Image();
            $img->image_caption =  $idTrab->nombre;
            $img->image_path = $this->upload($imgg);
            $img->servicio_id = $idTrab->id;
            $img->save();
        }
    }
}
