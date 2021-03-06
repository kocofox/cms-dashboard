<?php

namespace App\Http\Controllers;

use App\Http\Resources\WebResource;
use App\Http\Resources\NoticiaResource;
use App\Http\Resources\NoticiahomeResource;
use App\Http\Resources\ServicioResource;
use App\Http\Resources\TrabajoResource;
use App\Http\Resources\InfowebResource;
use App\Http\Resources\UsResource;
use App\Models\Noticia;
use App\Models\Contacto;
use App\Models\Servicio;
use App\Models\Trabajo;
use App\Models\Cliente;
use App\Models\Web;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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
                'clientes' => Cliente::orderBy('id','desc')->take(30)->get(),
                'count' => Cliente::count(),
            ],
            'Servicios' => [
                'Servicio' => Servicio::orderBy('id','desc')->take(4)->get(),
                'count' => Servicio::count(),
            ],
            'Trabajos' => [
                'Trabajo' => Trabajo::orderBy('id','desc')->take(4)->get(),
                'count' => Trabajo::count(),
            ]

        ];

        return WebResource::collection($data);
    }
    public function nosotros()
    {
        $data =  Web::find(1);

        return new UsResource($data);
    }
    public function datosweb()
    {
        $data =  Web::find(1);

        return new InfowebResource($data);
    }
    public function noticiasver()
    {

        return NoticiahomeResource::collection(Noticia::orderBy('id','desc')->paginate(request('per_page')));
    }
    public function noticia(Noticia $noticia)
    {
        return new NoticiaResource($noticia);
    }
    public function serviciosver()
    {
        return ServicioResource::collection(Servicio::orderBy('id','desc')->paginate(request('per_page')));
    }
    public function trabajosver()
    {
        return TrabajoResource::collection(Trabajo::orderBy('id','desc')->paginate(request('per_page')));
    }
    public function servicio(Servicio $servicio)

    {

        return new ServicioResource($servicio);
    }
    public function trabajo(Trabajo $trabajo)

    {

        return new TrabajoResource($trabajo);
    }
    public function dashboard()
    {
        $clima = Http::post('https://deperu.com/api/rest/temperaturaAhora.json');
        $cambio = Http::post('https://deperu.com/api/rest/cotizaciondolar.json');
        $data = [


            'Noticias' => [
                'data' => NoticiahomeResource::collection(Noticia::take(3)->get()),
                'count' => Noticia::count(),
            ],
            'Mensajes' => [
                'data' => WebResource::collection(Contacto::take(3)->get()),
                'count' => Contacto::count(),
            ],

            'Clima' => $clima->json(),
            'Cambio' => $cambio->json()




        ];

        return WebResource::collection($data);
    }
}
