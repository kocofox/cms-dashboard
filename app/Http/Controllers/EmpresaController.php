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
        return WebResource::collection(Empresa::paginate(request('per_page')));
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
        $logodel = $empresa->url;
        $img = Str::replace(env('APP_URL'), '', $empresa->url);
        $url_image = $this->upload($request->file('logo'));
        $horario = json_decode($request->horario);
        $tag = json_decode($request->etiquetas);
        $empresa->update($request->all());
        $empresa->update(
            [
                'horario' => $horario,
                'etiquetas' => $tag
            ]
        );
        if ($request->file('url')) {
            if ($empresa->url) {
                File::delete($img);
                $empresa->update(
                    [
                        'url' =>  $url_image
                    ]
                );
            } else {
                $empresa->created([
                    'url' => $url_image
                ]);
            }
        } else {
            $empresa->update(
                [
                    'logo' => $logodel

                ]
            );
        }

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
        $post_path = 'images/empresas';

        $rename = uniqid() . '-' . $name . '.' . $path_info['extension'];
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL') . "$post_path/$rename";
    }
}
