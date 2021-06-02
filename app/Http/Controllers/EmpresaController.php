<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarEmpresaRequest;
use App\Http\Requests\GuardarEmpresaRequest;
use App\Http\Resources\WebResource;
use App\Models\Empresa;
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
        
        return (new WebResource(Empresa::create($request->all())))->additional(['msg' => 'Empresa agregada correctamente']);
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
        $empresa->update($request->all());
      
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
        $empresa->delete();
        
        return (new WebResource($empresa))->additional(['msg' => 'Empresa eliminada correctamente']);
    }
}
