<?php

namespace App\Http\Controllers\API;

use App\Models\Permiso;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class PermisoRoleController extends Controller
{
    public function mostrarModelos()
    {
        return  Permiso::select(DB::Raw("DISTINCT( SUBSTRING_INDEX(SUBSTRING_INDEX(directriz, '.', 1), '.', -1)) as nombre"))
                            ->orderBy('nombre')->get();
    }

    public function mostrarPermisos(Request $request) {
        $request->modelo = $request->modelo.'%';
        return Permiso::select('id','nombre','directriz','descripcion')
                        ->where('directriz','like',$request->modelo)
                        ->get();
    }

    public function mostrarRolePermisos(Request $request)
    {
        //Definimos las reglas de Validación
        $reglas = [
            'role_id' => 'required'
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        $role = Role::with('permisos')->where('id',$request->role_id)->first();

        return response()->json([
            'role' => $role,
            'role_permisos' => $role->permisos
        ]);
    }

    public function guardarRolePermission(Request $request)
    {
        $role = Role::where('id',$request->role_id)->first();

        $role->asignarPermisos($request->permiso_id);

        return "Permisos Asignados Satisfactoriamente";
    }
}
