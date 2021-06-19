<?php

namespace App\Http\Controllers;

use App\Http\Resources\WebResource;
use App\Http\Resources\NoticiaResource;
use App\Http\Resources\NoticiahomeResource;
use App\Http\Resources\InfowebResource;
use App\Models\Noticia;
use App\Models\Contacto;
use App\Models\Servicio;
use App\Models\Cliente;
use App\Models\Web;
use App\Models\Banner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $data = [

            'Banner' => Banner::all(),
            'Noticias' => [
                'data' => NoticiahomeResource::collection(Noticia::take(3)->get()),
                'count' => Noticia::count(),
            ],
            'Mensajes' => [
                'count' => Contacto::count(),
            ],
            'Clientes' => [
                'clientes' => Cliente::take(6)->get(),
                'count' => Cliente::count(),
            ],
            'Servicios' => [
                'Servicio' => Servicio::take(4)->get(),
                'count' => Servicio::count(),
            ]
        ];

        return WebResource::collection($data);
    }
    public function datosweb()
    {
        $data =  Web::all();
        
        return InfowebResource::collection(Web::all());
    }
}
