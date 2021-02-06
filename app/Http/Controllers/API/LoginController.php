<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $reglas=[
            'name' => 'required|string|max:191',
            'password' => 'required|string|max:191',
        ];

        $mensaje=[
            'required' =>'* Campo Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        $user = User::where('name', $request->name)->first();

        $credenciales = ['name' => $request->name,'password' => $request->password];
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                if(auth()->attempt($credenciales)){
                    $user = auth()->user();
                    $usuario = User::with(['persona' => function($q){
                        $q->select('id','nombres','apellidos','numero_documento');
                    },'roles','roles.permisos','roles.menus'] )->where('id', $user->id)->first();

                    $success['token'] = $user->createToken('token-api',[''])->accessToken;
                    $success['user'] = $usuario;
                    $success['user']['roles'] =$user->roles;

                    $permisos =[];
                    $menus =[];
                    foreach($user->roles as $role)
                    {
                        $permisito = $user->obtenerPermisos($role->id)->toArray();
                        array_merge($permisito,$permisos);
                        $menuitem = $user->obtenerMenus($role->id)->toArray();
                        array_merge($menuitem,$menus);
                    }

                    $success['user']['permisos'] = $permisito;
                    $success['user']['menus'] = $menuitem;

                    return response($success, 200);
                }
                // $token = $user->createToken('token-sis')->accessToken;
                // $response = ['token' => $token];
            } else {
                $response = ['errors' =>['password' => 'Contraseña Incorrecta']];
                return response($response, 422);
            }
        } else {
            $response = ['errors' =>['name' => 'Nombre de Usuario no Válido']];
            return response($response, 422);
        }
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens->each(function ($token,$key){
            $token->delete();
        });

        $response = ['ok' => 1 , 'mensaje' =>'Sessión Cerrada Satisfactoriamente' ];

        return response()->json($response,200);

        // $token = $request->user()->token();
        // $token->revoke();
        // $response = ['message' => 'You have been successfully logged out!'];
        // return response($response, 200);
    }

    public function registro()
    {

    }
}
