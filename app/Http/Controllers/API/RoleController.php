<?php

namespace App\Http\Controllers\API;

use App\Models\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RoleController extends Controller
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
        return Role::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(roles.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(roles.directriz)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Role::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(roles.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(roles.directriz)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Role::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(roles.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(roles.directriz)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->onlyTrashed()->paginate($request->pagina);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Definimos las reglas de Validación
        $reglas = [
            'nombre' => 'required|string|max:191',
            'directriz' => 'required|string|max:191',
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo 191 caracteres',
            'exists' => 'Ya existe la directriz'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        //Insertamos el Rol
        $role = Role::create([
            'nombre' => $request->nombre,
            'directriz' => $request->directriz,
        ]);

        return "Rol registrado Exitósamente";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Role::where('id',$id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $role =  $this->show($request->id);

        $role->nombre = $request->nombre;
        $role->directriz = $request->directriz;
        $role->save();

        return "Rol Modificado Exitósamente";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::withTrashed()->where('id',$id);
        $role->forceDelete();

        return "Rol eliminado Permanentemente";
    }

    public function destroyTemporal(Request $request)
    {
        $role = Role::withTrashed()->where('id',$request->id);
        $role->delete();

        return "Rol Enviado a Papelera Satisfactoriamente";
    }

    public function restaurar(Request $request)
    {
        $role = Role::onlyTrashed()->where('id',$request->id);
        $role->restore();

        return "Rol Restaurado Satisfactoriamente";
    }

    public function listar()
    {
        return Role::select('id','nombre','directriz')->get();
    }

    public function mostrarFechaTimeZone()
    {
        $role = Role::first();

        return response()->json([
            'Lima GMT' => substr(Carbon::now('America/Lima')->format('c'),-6),
            'Ciudad México GMT' => substr(Carbon::now('America/Mexico_City')->format('c'),-6),
            'MFecha Creada GMT' => substr(Carbon::parse($role->created_at)->format('c'),-6)
        ], 200);
    }
}
