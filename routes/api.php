<?php

use App\Http\Controllers\WebController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\NoticiaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\UsuariosController;
use App\Http\Controllers\TrabajoController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//info empresa
Route::get('home', [HomeController::class, 'index']);
Route::get('inicio', [HomeController::class, 'datosweb']);
Route::get('nosotros', [HomeController::class, 'nosotros']);
Route::get('noticia', [HomeController::class, 'noticiasver']);
Route::get('noticia/{noticia}', [HomeController::class, 'noticia']);
Route::get('servicio', [HomeController::class, 'serviciosver']);
Route::get('trabajo', [HomeController::class, 'trabajosver']);
Route::get('servicio/{servicio}', [HomeController::class, 'servicio']);
Route::get('trabajo/{trabajo}', [HomeController::class, 'trabajo']);
//Route::post('mensajes', [ContactenosController::class, 'mensaje']);
Route::post('mensajes', 'App\Http\Controllers\ContactenosController@mensaje');
Route::get('imagenes/{url}/{id}', [ImagenController::class, 'getAll']);
//login
//Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@authenticate');
//Route::get('/usuarios', 'App\Http\Controllers\UserController@index');

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::post('user',  [AuthController::class, 'getuser']);
    Route::get('logout', [AuthController::class, 'logout']);
    //cruds
    Route::get('dashboard', [HomeController::class, 'dashboard']);
    //Route::get('imagenes/{id}', [ImagenController::class, 'getAll']);
    Route::post('deleteimg/{id}', [ImagenController::class, 'eliminarImg']);
    Route::apiResource('web', WebController::class);
    Route::apiResource('banner', BannerController::class);
    Route::apiResource('noticias', NoticiaController::class);
    Route::apiResource('categorias', CategoriaController::class);
    Route::apiResource('empresa', EmpresaController::class);
    Route::apiResource('clientes', ClienteController::class);
    Route::apiResource('servicios', ServicioController::class);
    Route::apiResource('trabajos', TrabajoController::class);
    Route::apiResource('roles', RoleController::class);
    Route::apiResource('contacto', ContactoController::class);
    Route::apiResource('usuarios', UsuariosController::class);
    Route::apiResource('profiles', ProfileController::class);
});
