<?php

namespace App\Http\Controllers;
use App\Http\Resources\WebResource;
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
            'Infoweb' => Web::all(),
            'Banner' => Banner::all(),
            'Noticias' => [
                'noticias'=> Noticia::all(),
                'count' => Noticia::count(),
            ],
            'Mensajes' => [
                'count' => Contacto::count(),
            ],
            'Clientes' => [
                'count' => Cliente::count(),
            ],
            'Servicios' => [
                'count' => Servicio::count(),
            ]
        ];
        
        return WebResource::collection($data);
    }

}
