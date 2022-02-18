<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarRoleRequest;
use App\Http\Requests\GuardarRoleRequest;
use App\Http\Resources\WebResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WebResource::collection(Profile::orderBy('id','desc')->paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarRoleRequest $request)
    {
        
        return (new WebResource(Profile::create($request->all())))->additional(['msg' => 'Profile agregada correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $role)

    {
       
        return new WebResource($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarRoleRequest $request, Profile $role)
    {
        $role->update($request->all());
      
        return (new WebResource($role))->additional(['msg' => 'Profile actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $role)
    {
        $role->delete();
        
        return (new WebResource($role))->additional(['msg' => 'Profile eliminada correctamente']);
    }
}
