<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActualizarBannerRequest;
use App\Http\Requests\GuardarBannerRequest;
use App\Http\Resources\WebResource;
use App\Models\Banner;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
        return WebResource::collection(Banner::orderBy('id','desc')->paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuardarBannerRequest $request)
    {
        $request->validated();


        $banner = new Banner();

        $url_image = $this->upload($request->file('url'));
        $banner->url = $url_image;
        $banner->alt = $request->input('alt');
        $banner->link = $request->input('link');
        $banner->descripcion = $request->input('descripcion');
        $banner->urls = json_decode($request->input('urls'));

        $banner->save();

        return (new WebResource($banner))->additional(['msg' => 'Banner agregado correctamente']);
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

        $bannerdel = $banner->url;
        
        
        $text = json_decode($request->urls);

        $banner->update($request->all());
        $banner->update(
            [
                'urls' => $text
            ]
        );
        if ($request->file('url')) {
            $url_image = $this->upload($request->file('url'));
            if ($banner->url) {
                $img = Str::replace(env('APP_URL'), '', $banner->url);
                File::delete($img);
                $banner->update(
                    [
                        'url' =>  $url_image
                    ]
                );
            } else {
                $banner->created([
                    'url' => $url_image
                ]);
            }
        } else {
            $banner->update(
                [
                    'logo' => $bannerdel

                ]
            );
        }



        return (new WebResource($banner))->additional(['msg' => 'Banner actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {     
        $imgdel = Str::replace(env('APP_URL'), '', $banner->url);
        File::delete($imgdel);
        $banner->delete();

        return (new WebResource($banner))->additional(['msg' => 'Banner eliminado correctamente']);
    }

    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/slider';

        $rename = uniqid() . '-' . $name;
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL') . "$post_path/$rename";
    }
}
