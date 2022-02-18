<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarClienteRequest;
use App\Http\Requests\GuardarClienteRequest;
use App\Http\Resources\WebResource;
use App\Models\Cliente;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WebResource::collection(Cliente::orderBy('id','desc')->paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarClienteRequest $request)
    {
        $request->validated();


        $cliente = new Cliente();

        $url_image = $this->upload($request->file('logo'));
        $cliente->logo = $url_image;
        $cliente->razonSocial = $request->input('razonSocial');
        $cliente->horario = json_decode($request->input('horario'));
        $cliente->ruc = $request->input('ruc');
        $cliente->direccion = $request->input('direccion');
        $cliente->telefono = $request->input('telefono');
        $cliente->correo = $request->input('correo');
        $cliente->slogan = $request->input('slogan');
        

        $cliente->save();
        return (new WebResource($cliente))->additional(['msg' => 'Cliente agregado correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)

    {
       
        return new WebResource($cliente);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarClienteRequest $request, Cliente $cliente)
    {
        $logodel = $cliente->logo;
        
        
        $horario = json_decode($request->horario);
        $cliente->update($request->all());
        $cliente->update(
            [
                'horario' => $horario
            ]
        );
        if ($request->file('logo')) {
            $url_image = $this->upload($request->file('logo'));
            if ($cliente->logo) {
                $img = Str::replace(env('APP_URL'), '', $logodel);
                File::delete($img);
                $cliente->update(
                    [
                        'logo' =>  $url_image
                    ]
                );
            } else {
                $cliente->created([
                    'logo' => $url_image
                ]);
            }
        } else {
            $cliente->update(
                [
                    'logo' => $logodel

                ]
            );
        }
      
        return (new WebResource($cliente))->additional(['msg' => 'Cliente actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $imgdel = Str::replace(env('APP_URL'), '', $cliente->logo);
        File::delete($imgdel);
        $cliente->delete();
        
        return (new WebResource($cliente))->additional(['msg' => 'Cliente eliminado correctamente']);
    }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/clientes';

        $rename = uniqid() . '-' . $name;
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL') . "$post_path/$rename";
    }
}
