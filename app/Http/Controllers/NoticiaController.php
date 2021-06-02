<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarNoticiaRequest;
use App\Http\Requests\GuardarNoticiaRequest;
use App\Http\Resources\NoticiaResource;
use App\Models\Noticia;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return NoticiaResource::collection(Noticia::paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarNoticiaRequest $request)
    {
        $request->validated();


        $post = new Noticia();

        $url_image = $this->upload($request->file('img'));
        $post->img = $url_image;
        $post->titulo = $request->input('titulo');
        $post->contenido = $request->input('contenido');
        $post->categoria_id = $request->input('categoria_id');
        $post->user_id = $request->input('user_id');
        $post->etiquetas = $request->input('etiquetas');
        $post->redes = $request->input('redes');
        $post->otros = $request->input('otros');
        $post->save();
        //$res = 
        //return (new NoticiaResource(Noticia::create($request->all())))->additional(['msg' => 'Noticia agregada correctamente']);

        return (new NoticiaResource($post))->additional(['msg' => 'Noticia agregada correctamente c']);
    }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/post';

        $rename = uniqid() . '-' . $name . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);
        return "$post_path/$rename";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Noticia $noticia)

    {

        return new NoticiaResource($noticia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarNoticiaRequest $request, Noticia $noticia)
    {

       
        $imgdel = $noticia->img;
       
        $noticia->update($request->all());
        if ($request->file('img')) {
            $url_image = $this->upload($request->file('img'));
           
            if ($noticia->img) {
                
                File::delete($imgdel);
                $noticia->update(
                    [
                        'img' => $url_image,
                        
                    ]
                );
            } else {
                $noticia->created([
                    'img' => $url_image
                ]);
            }
        }

        return (new NoticiaResource($noticia))->additional(['msg' => 'Noticia actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Noticia $noticia)
    
    {
        $imgdel = $noticia->img;
        File::delete($imgdel);
        $noticia->delete();

        return (new NoticiaResource($noticia))->additional(['msg' => 'Noticia eliminada correctamente']);
    }
}
