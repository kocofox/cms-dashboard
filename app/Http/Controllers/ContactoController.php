<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarContactoRequest;
use App\Http\Requests\GuardarContactoRequest;
use App\Http\Resources\WebResource;
use App\Models\Contacto;
use Illuminate\Http\Request;

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
        
        return (new WebResource(Contacto::create($request->all())))->additional(['msg' => 'Contacto agregada correctamente']);
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
