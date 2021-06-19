<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\ActualizarUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return UserResource::collection(User::paginate(request('per_page')));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $url_image = $this->upload($request->file('avatar'));
        $user = User::create([
            'name' => $request->get('name'),
            'fullname' => $request->get('fullname'),
            'profiles_id' => $request->get('profiles_id'),
            'avatar' => $this->upload($request->file('avatar')),
            'email' => $request->get('email'),


            'password' => Hash::make($request->get('password')),
        ]);

        // $token = JWTAuth::fromUser($user);

        //return response()->json(compact('user', 'token'), 201);
        return (new UserResource($user))->additional(['msg' => 'Usuario agregado correctamente']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $usuario)
    {
        return new UserResource($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ActualizarUserRequest $request, User $usuario)
    {
        $avatardel = $usuario->avatar;
        $uavatar = $usuario->avatar;
        $upw = $request->get('password');
        $pw = $usuario->password;
        if ($request->file('avatar')) {
            $url_image = $this->upload($request->file('avatar'));

            if ($usuario->avatar) {
                $avatar = Str::replace(env('APP_URL'), '', $avatardel);
                File::delete($avatar);
                $uavatar =  $url_image;
            } else {
                $uavatar =  $url_image;
            }
        } else {
            $uavatar =  $avatardel;
        }
        if ($request->get('password')) {
            $upw = Hash::make($request->get('password'));
        } else {
            $upw = $pw;
        };
           // $user = $usuario;
            $usuario->name = $request->get('name');
            $usuario->fullname = $request->get('fullname');
            $usuario->profiles_id = $request->get('profiles_id');
            $usuario->avatar = $uavatar;
            $usuario->email = $request->get('email');


            $usuario->password = $upw;
        

        $usuario->save();


        return (new UserResource($usuario))->additional(['msg' => 'Usuario actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $usuario)
    {

        $usuario->delete();

        return (new UserResource($usuario))->additional(['msg' => 'Usuario eliminado correctamente']);
    }
    private function upload($image)
    {
        $filename =  $image->getClientOriginalName();
        $name = Str::replace(" ", '_', $filename);
        $path_info = pathinfo($image->getClientOriginalName());
        $post_path = 'images/avatars';

        $rename = uniqid() . '-' . $name;
        $image->move(public_path() . "/$post_path", $rename);
        return env('APP_URL') . "$post_path/$rename";
    }
}
