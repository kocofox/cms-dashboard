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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//info empresa
//Route::apiResource('web', WebController::class);
// Route::get('/web', [WebController::class,'index']);
// Route::post('/web', [WebController::class,'store']);
// Route::patch('/web', [WebController::class,'update']);
Route::get('/home', [HomeController::class,'index']);
Route::get('/inicio', [HomeController::class,'datosweb']);
// //noticias
// Route::get('/noticias', [NoticiaController::class,'index']);
// Route::get('/noticias/{noticia}', [NoticiaController::class,'show']);
// Route::post('/noticias', [NoticiaController::class,'store']);
// Route::put('/noticias/{noticia}', [NoticiaController::class,'update']);
// Route::delete('/noticias/{noticia}', [NoticiaController::class,'destroy']);
Route::apiResource('web', WebController::class);
Route::apiResource('banner', BannerController::class);
Route::apiResource('noticias', NoticiaController::class);
Route::apiResource('categorias', CategoriaController::class);
Route::apiResource('empresa', EmpresaController::class);
Route::apiResource('clientes', ClienteController::class);
Route::apiResource('servicios', ServicioController::class);
Route::apiResource('roles', RoleController::class);
Route::apiResource('contacto', ContactoController::class);
Route::apiResource('usuarios', UsuariosController::class);
Route::apiResource('profiles', ProfileController::class);


//login
Route::post('/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@authenticate');
//Route::get('/usuarios', 'App\Http\Controllers\UserController@index');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::post('user','App\Http\Controllers\AuthController@get_user');
    Route::get('logout','App\Http\Controllers\AuthController@logout');

});