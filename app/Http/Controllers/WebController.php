<?php

namespace App\Http\Controllers;
use App\Http\Requests\ActualizarWebRequest;
use App\Http\Requests\GuardarWebRequest;
use App\Http\Resources\WebResource;
use App\Models\Web;
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
            return WebResource::collection(Web::all());
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
        return new WebResource($web);
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
        $web->update($request->all());
      
        return (new WebResource($web))->additional(['msg' => 'Datos actualizados correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
}
