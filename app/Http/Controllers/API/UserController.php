<?php

namespace App\Http\Controllers\API;

use Auth;
use App\Models\User;
use App\Models\Role;
use App\Models\Persona;
use App\Models\TipoDocumento;

use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return User::with(['persona' => function($q){
                        $q->select('id','nombres','apellidos','numero_documento');
                    },'roles'] )
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(users.name)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(users.email)"),'like','%'.$buscar.'%')
                        ->orwhereHas('persona',function($query) use($buscar){
                            $query->where(DB::Raw("concat(upper(nombres),' ',upper(apellidos))"),'like','%'.$buscar.'%');
                        });
                    })
                    ->paginate($request->pagina);
    }

    public function todos(Request $request) {
        $buscar = strtoupper($request->buscar);
        return User::with(['persona:id,nombres,apellidos,numero_documento','roles'])
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(users.name)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(users.email)"),'like','%'.$buscar.'%')
                        ->orwhereHas('persona',function($query) use($buscar){
                            $query->where(DB::Raw("concat(upper(nombres),' ',upper(apellidos))"),'like','%'.$buscar.'%');
                        });
                    })
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return User::with(['persona:id,nombres,apellidos,numero_documento','roles'])
                    ->where(function($query) use($buscar){
                        $query->where(DB::Raw("upper(users.name)"),'like','%'.$buscar.'%')
                        ->orWhere(DB::Raw("upper(users.email)"),'like','%'.$buscar.'%')
                        ->orwhereHas('persona',function($query) use($buscar){
                            $query->where(DB::Raw("concat(upper(nombres),' ',upper(apellidos))"),'like','%'.$buscar.'%');
                        });
                    })
                    ->onlyTrashed()->paginate($request->pagina);
    }

    public function verificarNumeroDocumento(Request $request)
    {
        //VALIDAMOS EL TIPO DE DOCUMENTO
        $regla = [ 'tipo_documento_id' => 'required'];
        $mensaje = [ 'required' => '* Dato Obligatorio'];
        $this->validate($request,$regla,$mensaje);

        //VALIDAMOS EL NUMERO DE DOCUMENTO POR LONGITUD
        $tipoDocumento = TipoDocumento::select('longitud')
                                    ->where('id',$request->tipo_documento_id)->first();
        $digitos =$tipoDocumento->longitud;

        $regla = [
            'tipo_documento_id' => 'required',
            'numero_documento' => 'digits:'.$digitos
        ];
        $mensaje = [ 'required' => '* Dato Obligatorio',
                    'digits' => 'Ingrese '.$digitos.' dígitos'];
        $this->validate($request,$regla,$mensaje);

        $persona = null;
        if($digitos == 8)
        {
            $cs = new Dni(new ContextClient(), new DniParser());

            $persona = $cs->get($request->numero_documento);
            if (!$persona) {
                return null;
            }
        } else if($digitos == 11)
        {
            $cs = new Ruc(new ContextClient(), new RucParser(new HtmlParser()));
            $persona = $cs->get($request->numero_documento);
            if (!$persona) {
                return null;
            }
        }

        return json_encode($persona);
        //return $persona;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regla = [
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required|unique:personas,numero_documento',
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
            'sexo' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|confirmed',
            'password_confirmation' =>'required'
        ];
        $mensaje = [ 'required' => '* Dato Obligatorio',
                    'max' => 'Ingrese máximo 191 caracteres',
                    'confirmed' =>'el campo confirmación debe ser igual'];

        $this->validate($request,$regla,$mensaje);

         //Registramos Datos de la Persona
         $persona = Persona::create([
            'tipo_documento_id' => $request->tipo_documento_id,
            'numero_documento' => $request->numero_documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion
        ]);

        //Registramos el Usuarios de la persona
        $user = User::create([
            'persona_id' => $persona->id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'foto' => ($request->sexo =='M') ? 'images/user_male.png': 'images/user_female.png'
        ]);

        //Asigamos los roles Seleccionados
        $user->asignarRoles($request->role_id);

        return "Usuario Registrado Satisfactoriamente";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $usuario = User::select('id','name','email','persona_id','foto')
                        ->where('id',$request->id)->first();
        $persona = Persona::select('id','tipo_documento_id','numero_documento','nombres',
                                'apellidos','sexo','telefono','direccion')
                        ->where('id',$usuario->persona_id)->first();


        return response()->json([
            'usuario' => $usuario,
            'persona' => $persona,
            'roles' => $usuario->roles->pluck('id')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $usuario = User::where('id',$request->id)->first();

        $regla = [
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required|unique:personas,numero_documento,'.$request->persona_id,
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
            'sexo' => 'required',
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$request->id
        ];
        $mensaje = [ 'required' => '* Dato Obligatorio',
                    'max' => 'Ingrese máximo 191 caracteres',
                    'confirmed' =>'el campo confirmación debe ser igual',
                    'unique' => 'El Número Documento ya existe'
        ];

        $this->validate($request,$regla,$mensaje);

        if($request->name != $usuario->name)
        {
            $usuario->name = $request->name;
            $usuario->save();
        }
        if($request->email != $usuario->email)
        {
            $usuario->email = $request->email;
            $usuario->save();
        }

        $persona = Persona::where('id',$usuario->persona_id)->first();

        $persona->tipo_documento_id= $request->tipo_documento_id;
        $persona->numero_documento= $request->numero_documento;
        $persona->nombres= $request->nombres;
        $persona->apellidos= $request->apellidos;
        $persona->sexo= $request->sexo;
        $persona->telefono= $request->telefono;
        $persona->direccion= $request->direccion;
        $persona->save();

        //Asigamos los roles Seleccionados
        $usuario->asignarRoles($request->role_id);

        return "Usuario Modificado Satisfactoriamente";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::withTrashed()->where('id',$id)->first();
        $persona = Persona::where('id',$user->persona_id)->first();
        //Quitamos todos los roles
        $user->eliminarRolesTodo();
        //Eliminamos el usuario
        $user->forceDelete();
        //Eliminados sus datos personales
        $persona->delete();
        return "Usuario eliminado Permanentemente";
    }

    public function destroyTemporal(Request $request)
    {
        $user = User::withTrashed()->where('id',$request->id);
        $user->delete();

        return "Usuario Enviado a Papelera Satisfactoriamente";
    }

    public function restaurar(Request $request)
    {
        $user = User::onlyTrashed()->where('id',$request->id);
        $user->restore();

        return "Usuario Restaurado Satisfactoriamente";
    }

    public function obtenerDatosUsuario(Request $request)
    {
        $user = User::where('id',$request->user_id)->first();
        $success['user'] = $user;
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

        return $success;
    }

    public function ListarCobradores()
    {
        return User::join('role_user as ru','users.id','=','ru.user_id')
                ->join('roles as r','r.id','=','ru.role_id')
                ->join('personas as p','users.persona_id','=','p.id')
                ->select('users.id',DB::Raw("concat(upper(p.nombres),' ',upper(p.apellidos)) as nombre"))
                ->where('r.directriz','cobrador')
                ->get();
    }

}
