<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarWebRequest;
use App\Http\Requests\GuardarWebRequest;
use App\Http\Resources\WebResource;
use App\Http\Resources\InfoResource;
use App\Models\Web;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Web::all();
        {
            return InfoResource::collection(Web::all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarWebRequest $request)
    {
        Web::create($request->all());
        return response()->json(
            [
                'res' => true,
                'msg' => 'Agregado correctamente'
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Web $web)
    {
        //
        return new InfoResource($web);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarWebRequest $request, Web $web)
    {
        //$web->update($request->all());

        // return (new WebResource($web))->additional(['msg' => 'Datos actualizados correctamente']);
        // $logodel = $web->logo;
        // $favicondel = $web->favicon;
        $old = $web;
        $logodel = Str::replace(env('APP_URL'), '', $web->logo);
        $favidel = Str::replace(env('APP_URL'), '', $web->favicon);
        $nosdel = Str::replace(env('APP_URL'), '', $web->nosotros);
        $midel = Str::replace(env('APP_URL'), '', $web->mision);
        $videl = Str::replace(env('APP_URL'), '', $web->vision);
        // $img = Str::replace(env('APP_URL'), '', $web->url);
       
       
      
       
       
        $pie = json_decode($request->footer);
        $redes = json_decode($request->redes);
        $etiquetas = json_decode($request->etiquetas);
        //dd($pie);



        $web->update($request->all());
        $web->update(
            [
                'footer' => $pie,
                'redes' => $redes,
                'etiquetas' => $etiquetas

            ]
        );

        if ($request->file('logo')) {
            File::delete($logodel);
            $logo_image = $this->upload($request->file('logo'));
            $web->update(['logo' =>  $logo_image]);
        } else {
            $web->update(['logo' =>  $old->logo]);
        }
        if ($request->file('favicon')) {
            File::delete($favidel);
            $favicon_image = $this->upload($request->file('favicon'));
            $web->update(['favicon' =>  $favicon_image]);
        } else {
            $web->update(['favicon' =>  $old->favicon]);
        }
        if ($request->file('nosotros')) {
            File::delete($nosdel);
            $nosotros_image = $this->upload($request->file('nosotros'));
            $web->update(['nosotros' =>  $nosotros_image]);
        } else {
            $web->update(['nosotros' =>  $old->nosotros]);
        }
        if ($request->file('vision')) {
            File::delete($midel);
            $vision_image = $this->upload($request->file('vision'));
            
            $web->update(['vision' =>  $vision_image]);
        } else {
            $web->update(['vision' =>  $old->vision]);
        }
        if ($request->file('mision')) {
            File::delete($videl);
            $mision_image = $this->upload($request->file('mision'));
            $web->update(['mision' =>  $mision_image]);
        } else {
            $web->update(['mision' =>  $old->mision]);
        }





        //dd($web->footer)    ;
        // if ($request->file('logo')) {
        //     $url_image = $this->upload($request->file('logo'));

            // if ($web->logo) {

            //     $img = Str::replace(env('APP_URL'), '', $logodel);
            //     File::delete($img);
            //     $web->update(
            //         [
            //             'logo' => $url_image,

            //         ]
            //     );
            // } else {
            //     $web->created([
            //         'logo' => $url_image
            //     ]);
            // }
        // } else {
        //     $web->update(
        //         [
        //             'logo' => $logodel

        //         ]
        //     );
        // }
        // if ($request->file('favicon')) {
        //     $url_image2 = $this->upload($request->file('favicon'));
        //     if ($web->favicon) {
        //         $imgf = Str::replace(env('APP_URL'), '', $favicondel);
        //         File::delete($imgf);
        //         $web->update(
        //             [
        //                 'favicon' => $url_image2,

        //             ]
        //         );
        //     } else {
        //         $web->created([
        //             'favicon' => $url_image2
        //         ]);
        //     }
        // } else {
        //     $web->update(
        //         [
        //             'favicon' => $favicondel

        //         ]
        //     );
        // }
        //$web->update($request->all());
        //dd($web->footer);
        return (new WebResource($web))->additional(['msg' => 'Info de empresa actualizada correctamente']);
    }


    // private function upload($image)
    // {
    //     $filename =  $image->getClientOriginalName();
    //     $name = Str::replace(" ", '_', $filename);
    //     $path_info = pathinfo($image->getClientOriginalName());
    //     $post_path = 'images/web';

    //     $rename = uniqid() . '-' . $name;
    //     $image->move(public_path() . "/$post_path", $rename);
    //     $fullimg = env('APP_URL') . "$post_path/$rename";
    //     //dd($fullimg);
    //     return $fullimg;
    // }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/web';

        $rename = uniqid() . '-' . $name . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);

        //return env('APP_URL') . "$post_path/$rename";
        $fullimg = env('APP_URL') . "$post_path/$rename";
       
        return $fullimg;
    }
}
