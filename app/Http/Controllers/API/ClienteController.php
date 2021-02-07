<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClienteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Peru\Http\ContextClient;
use Peru\Jne\{Dni, DniParser};
use Peru\Sunat\{HtmlParser, Ruc, RucParser};

use App\Models\Cliente;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\Valoracion;
use App\Models\User;

class ClienteController extends Controller
{

    public function rolUsuario($usuario)
    {
        $user = User::with('roles')->where('id',$usuario)->first();
        $rol = "";
        foreach($user->roles as $role)
        {
            $rol = $role->directriz;
            break;
        }

        return $rol;
    }

    public function index()
    {
        //
    }



    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        $usuario = $request->usuario;
        $role = $this->rolUsuario($usuario);

        if($role=='super-usuario' || $role=='administrador')
        {
            $usuario='%';
        }

        return Cliente::with(['persona' => function($q){
                        $q->select('id','nombres','apellidos','numero_documento');
                    },'valoracion:id,nombre,icono,clase',
                    'users.persona:id,nombres,apellidos'] )
                    ->where(function($query) use($buscar){
                        $query->whereHas('persona',function($query) use($buscar){
                            $query->where(DB::Raw("concat(upper(nombres),' ',upper(apellidos))"),'like','%'.$buscar.'%')
                                ->orWhere("numero_documento",'like','%'.$buscar.'%');
                        });
                    })
                    ->whereHas('users',function($query) use($usuario){
                        $query->where('users.id','like',$usuario);
                    })
                    ->paginate($request->pagina);
    }

    public function todos(Request $request) {
        $buscar = strtoupper($request->buscar);
        $usuario = $request->usuario;
        $role = $this->rolUsuario($usuario);

        if($role=='super-usuario' || $role=='administrador')
        {
            $usuario='%';
        }

        return Cliente::with(['persona:id,nombres,apellidos,numero_documento',
                            'valoracion:id,nombre,icono,clase',
                            'users.persona:id,nombres,apellidos'])
                    ->where(function($query) use($buscar){
                        $query->whereHas('persona',function($query) use($buscar){
                            $query->where(DB::Raw("concat(upper(nombres),' ',upper(apellidos))"),'like','%'.$buscar.'%')
                                ->orWhere("numero_documento",'like','%'.$buscar.'%');
                        });
                    })
                    ->whereHas('users',function($query) use($usuario){
                        $query->where('users.id','like',$usuario);
                    })
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        $usuario = $request->usuario;
        $role = $this->rolUsuario($usuario);

        if($role=='super-usuario' || $role=='administrador')
        {
            $usuario='%';
        }

        return Cliente::with(['persona:id,nombres,apellidos,numero_documento',
                                'valoracion:id,nombre,icono,clase',
                                'users.persona:id,nombres,apellidos'])
                    ->where(function($query) use($buscar){
                        $query->whereHas('persona',function($query) use($buscar){
                            $query->where(DB::Raw("concat(upper(nombres),' ',upper(apellidos))"),'like','%'.$buscar.'%')
                                ->orWhere("numero_documento",'like','%'.$buscar.'%');
                        });
                    })
                    ->whereHas('users',function($query) use($usuario){
                        $query->where('users.id','like',$usuario);
                    })
                    ->onlyTrashed()->paginate($request->pagina);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

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

        $persona_buscar = Persona::where('tipo_documento_id',$request->tipo_documento_id)
                            ->where('numero_documento',$request->numero_documento)
                            ->first();


        $encontrado=0;
        $cliente_buscar = null;
        $user_buscar=null;
        $persona = null;
        if($persona_buscar)
        {
            $encontrado = 1;

            $cliente_buscar = Cliente::where('persona_id',$persona_buscar->id)->first();
            if($cliente_buscar)
            {
                $persona_buscar['cliente_id'] = $cliente_buscar->id;

                $user_buscar = Cliente::join('cliente_user as cu','clientes.id','=','cu.cliente_id')
                        ->select('cu.user_id')
                        ->where('clientes.id',$cliente_buscar->id)
                        ->first();

                if($user_buscar)
                {
                    $persona_buscar['user_id'] = $user_buscar->user_id;
                }
            }
        }
        else {
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
        }

        return response()->json([
            'encontrado' => $encontrado,
            'persona_buscar' => ($persona_buscar) ? $persona_buscar : null,
            'persona' => json_encode($persona)
        ], 200);

        //return $persona;
    }
    public function store(Request $request)
    {
        $regla = [
            'tipo_documento_id' => 'required',
            'numero_documento' => 'required|unique:personas,numero_documento|max:15',
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
            'sexo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'user_id' => 'required',
        ];

        $mensaje = [ 'required' => '* Dato Obligatorio',
            'max' => 'Ingrese máximo :max caracteres',
            'unique' => 'Número Documento Ya existe'
        ];

        $this->validate($request,$regla,$mensaje);

        $persona  = Persona::create([
            'tipo_documento_id' => $request->tipo_documento_id,
            'numero_documento' => $request->numero_documento,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'sexo' => $request->sexo,
            'telefono' => $request->telefono,
            'direccion' => $request->direccion
        ]);

        $cliente = Cliente::create([
            'persona_id' => $persona->id,
            'valoracion_id' => 1
        ]);

        $user = Cliente::join('cliente_user as cu','clientes.id','=','cu.cliente_id')
                ->select('cu.user_id')
                ->where('clientes.id',$cliente->id)
                ->where('cu.user_id',$request->user_id)
                ->first();

        if(!$user)
        {
            $cliente->users()->attach($request->user_id);
        }


        $persona['cliente_id'] =$cliente->id;

        return response()->json([
            'ok' => 1,
            'mensaje' =>'Cliente Registrado Satisfactoriamente',
            'cliente' => $persona
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $cliente = Cliente::select('id','persona_id','valoracion_id')
                    ->where('id',$request->id)
                    ->first();

        $persona = Persona::select('id','tipo_documento_id','numero_documento',
                            'nombres','apellidos','sexo','telefono','direccion')
                    ->where('id',$cliente->persona_id)
                    ->first();

        $cobrador = Cliente::join('cliente_user as cu','clientes.id','=','cu.cliente_id')
                        ->join('users as u','cu.user_id','=','u.id')
                        ->select('u.id')
                        ->where('clientes.id',$cliente->id)
                        ->first();
        $valoracion = Valoracion::select('id','nombre','icono','clase')
                        ->where('id',$cliente->valoracion_id)->first();

        return response()->json([
            'cliente' => $cliente,
            'persona' => $persona,
            'cobrador' => $cobrador,
            'valoracion' => $valoracion
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $regla = [
            'nombres' => 'required|string|max:191',
            'apellidos' => 'required|string|max:191',
            'sexo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'user_id' => 'required',
        ];

        $mensaje = [ 'required' => '* Dato Obligatorio',
            'max' => 'Ingrese máximo :max caracteres',
            'unique' => 'Número Documento Ya existe'
        ];

        $this->validate($request,$regla,$mensaje);

        $persona = Persona::where('tipo_documento_id',$request->tipo_documento_id)
                    ->where('numero_documento',$request->numero_documento)->first();

        $cliente = Cliente::where('id',$request->id)->first();


        $persona->tipo_documento_id = $request->tipo_documento_id;
        $persona->numero_documento = $request->numero_documento;
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->sexo = $request->sexo;
        $persona->telefono = $request->telefono;
        $persona->direccion = $request->direccion;
        $persona->save();

        $user = Cliente::join('cliente_user as cu','clientes.id','=','cu.cliente_id')
                    ->select('cu.user_id')
                    ->where('clientes.id',$cliente->id)
                    ->first();

        if($user)
        {
            if($user->user_id != $request->user_id)
            {
                $cliente->users()->detach($user->user_id);
                $cliente->users()->attach($request->user_id);
            }
        } else {
            $cliente->users()->attach($request->user_id);
        }


        $persona['cliente_id'] = $cliente->id;

        return response()->json([
            'ok' => 1,
            'mensaje' =>'Cliente Modificado Satisfactoriamente',
            'cliente' => $persona
        ], 200);
    }

    public function destroy($id)
    {
        $cliente = Cliente::withTrashed()->where('id',$id)->first();
        $persona = Persona::where('id',$user->persona_id)->first();
        //Quitamos todos los roles
        $cliente->users()->detach();
        //Eliminamos el usuario
        $cliente->forceDelete();
        //Eliminados sus datos personales
        $persona->delete();
        return "Cliente eliminado Permanentemente";
    }

    public function destroyTemporal(Request $request)
    {
        $cliente = Cliente::withTrashed()->where('id',$request->id);
        $cliente->delete();

        return "Cliente Enviado a Papelera Satisfactoriamente";
    }

    public function restaurar(Request $request)
    {
        $cliente = Cliente::onlyTrashed()->where('id',$request->id);
        $cliente->restore();

        return "Cliente Restaurado Satisfactoriamente";
    }

    public function reporteClientes(Request $request)
    {
        $usuario = $request->usuario;
        $clientes = Cliente::get();
        return $clientes;
    }
}
