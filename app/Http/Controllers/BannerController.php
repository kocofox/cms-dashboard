<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarBannerRequest;
use App\Http\Requests\GuardarBannerRequest;
use App\Http\Resources\WebResource;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return WebResource::collection(Banner::paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarBannerRequest $request)
    {
        
        return (new WebResource(Banner::create($request->all())))->additional(['msg' => 'Banner agregada correctamente']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)

    {
       
        return new WebResource($banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarBannerRequest $request, Banner $banner)
    {
        $banner->update($request->all());
      
        return (new WebResource($banner))->additional(['msg' => 'Banner actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {
        $banner->delete();
        
        return (new WebResource($banner))->additional(['msg' => 'Banner eliminada correctamente']);
    }
}
