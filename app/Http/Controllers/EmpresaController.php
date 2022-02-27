<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarEmpresaRequest;
use App\Http\Requests\GuardarEmpresaRequest;
use App\Http\Resources\WebResource;
use App\Models\Empresa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WebResource::collection(Empresa::orderBy('id', 'desc')->paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarEmpresaRequest $request)
    {

        $request->validated();


        $empresa = new Empresa();

        $url_image = $this->upload($request->file('logo'));
        $empresa->logo = $url_image;
        $empresa->razonSocial = $request->input('razonSocial');
        $empresa->horario = json_decode($request->input('horario'));
        $empresa->ruc = $request->input('ruc');
        $empresa->direccion = $request->input('direccion');
        $empresa->telefono = $request->input('telefono');
        $empresa->correo = $request->input('correo');
        $empresa->slogan = $request->input('slogan');
        $empresa->razonSocial = $request->input('razonSocial');

        $empresa->save();

        return (new WebResource($empresa))->additional(['msg' => 'Empresa agregada correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)

    {

        return new WebResource($empresa);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarEmpresaRequest $request, Empresa $empresa)
    {
        $old = $empresa;
        $logodel = Str::replace(env('APP_URL'), '', $empresa->logo);
        $favidel = Str::replace(env('APP_URL'), '', $empresa->favicon);
        $nosdel = Str::replace(env('APP_URL'), '', $empresa->nosotros);
        $midel = Str::replace(env('APP_URL'), '', $empresa->mision);
        $videl = Str::replace(env('APP_URL'), '', $empresa->vision);
        // $img = Str::replace(env('APP_URL'), '', $empresa->url);
        $logo_image = $this->upload($request->file('logo'));
        $favicon_image = $this->upload($request->file('favicon'));
        $nosotros_image = $this->upload($request->file('nosotros'));
        $mision_image = $this->upload($request->file('mision'));
        $vision_image = $this->upload($request->file('vision'));


        $tag = json_decode($request->etiquetas);

        $empresa->update($request->all());
        $empresa->update(
            [
                'etiquetas' => $tag
            ]
        );
        if ($request->file('logo')) {
            File::delete($logodel);
            $empresa->update(['logo' =>  $logo_image]);
        } else { $empresa->update(['logo' =>  $old->logo]);
        }
        if ($request->file('favicon')) {
            File::delete($favidel);
            $empresa->update(['favicon' =>  $favicon_image]);
        } else { $empresa->update(['favicon' =>  $old->favicon]);
        }
        if ($request->file('nosotros')) {
            File::delete($nosdel);
            $empresa->update(['nosotros' =>  $nosotros_image]);
        } else { $empresa->update(['nosotros' =>  $old->nosotros]);
        }
        if ($request->file('vision')) {
            File::delete($midel);
            $empresa->update(['vision' =>  $vision_image]);
        } else { $empresa->update(['vision' =>  $old->vision]);
        }
        if ($request->file('mision')) {
            File::delete($videl);
            $empresa->update(['mision' =>  $mision_image]);
        } else { $empresa->update(['mision' =>  $old->mision]);
        }


        // if ($request->file('logo')) {
        //     if ($empresa->url) {
        //         File::delete($img);
        //         $empresa->update(
        //             [
        //                 'url' =>  $url_image
        //             ]
        //         );
        //     } else {
        //         $empresa->created([
        //             'url' => $url_image
        //         ]);
        //     }
        // } else {
        //     $empresa->update(
        //         [
        //             'logo' => $logodel

        //         ]
        //     );
        // }

        return (new WebResource($empresa))->additional(['msg' => 'Empresa actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Empresa $empresa)
    {
        $imgdel = Str::replace(env('APP_URL'), '', $empresa->url);
        File::delete($imgdel);
        $empresa->delete();

        return (new WebResource($empresa))->additional(['msg' => 'Empresa eliminada correctamente']);
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
