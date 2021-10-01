<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarContactoRequest;
use App\Http\Requests\GuardarContactoRequest;
use App\Http\Resources\WebResource;
use App\Models\Contacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactanosMailable;
use Illuminate\Support\Str;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WebResource::collection(Contacto::paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarContactoRequest $request)
    {
       $request->validated();
       $correos = new Contacto();

        $url_image = $this->upload($request->file('imagen'));
        $correos->imagen = $url_image;
        $correos->razonSocial = $request->input('razonSocial');
        $correos->ruc = $request->input('ruc');
        $correos->asunto = $request->input('asunto');
        $correos->correo = $request->input('correo');
        $correos->mensaje = $request->input('mensaje');
        $correos->telefono = $request->input('telefono');
        $correos->save();

        //$smail = new ContactanosMailable($correos);
//Mail::to('kocofox@gmail.com') ->send( $smail ) ;
        return (new WebResource($correos))->additional(['msg' => 'Mensaje enviado correctamente']);
    }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/contacto';

        $rename = uniqid() . '-' . $name;
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL')."$post_path/$rename";
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contacto $contacto)

    {
       
        return new WebResource($contacto);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarContactoRequest $request, Contacto $contacto)
    {
        $contacto->update($request->all());
      
        return (new WebResource($contacto))->additional(['msg' => 'Contacto actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contacto $contacto)
    {
        $contacto->delete();
        
        return (new WebResource($contacto))->additional(['msg' => 'Contacto eliminada correctamente']);
    }
}
