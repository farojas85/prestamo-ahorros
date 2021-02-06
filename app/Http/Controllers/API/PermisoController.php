<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller
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
        $buscar = strtolower($request->buscar);
        return Permiso::where(function($query) use($buscar){
                        $query->where(DB::Raw("lower(nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("lower(directriz)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("lower(descripcion)"),'like','%'.$buscar.'%');
                    })
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtolower($request->buscar);
        return Permiso::where(function($query) use($buscar){
                            $query->where(DB::Raw("lower(nombre)"),'like','%'.$buscar.'%')
                                ->orWhere(DB::Raw("lower(directriz)"),'like','%'.$buscar.'%')
                                ->orWhere(DB::Raw("lower(descripcion)"),'like','%'.$buscar.'%');
                        })
                        ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtolower($request->buscar);
        return Permiso::where(function($query) use($buscar){
                            $query->where(DB::Raw("lower(nombre)"),'like','%'.$buscar.'%')
                                ->orWhere(DB::Raw("lower(directriz)"),'like','%'.$buscar.'%')
                                ->orWhere(DB::Raw("lower(descripcion)"),'like','%'.$buscar.'%');
                        })
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
            'directriz' => 'required|string|max:191|unique:permisos,directriz'
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo 191 caracteres',
            'unique' => 'La Directriz ya está en uso'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        //Insertamos el Permiso
        $permiso = Permiso::create([
            'nombre' => $request->nombre,
            'directriz' => $request->directriz,
            'descripcion' => $request->descripcion
        ]);

        return "Permiso registrado Exitósamente";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show(Permiso $permiso)
    {
        return $permiso;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         //Definimos las reglas de Validación
         $reglas = [
            'nombre' => 'required|string|max:191',
            'directriz' => 'required|string|max:191|unique:permisos,directriz,'.$request->id
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo 191 caracteres',
            'unique' => 'La Directriz ya está en uso'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        //Insertamos el Rol
        $permiso = Permiso::where('id',$request->id)->first();

        $permiso->nombre = $request->nombre;
        $permiso->directriz = $request->directriz;
        $permiso->descripcion = $request->descripcion;
        $permiso->save();

        return "Permiso Modificado Exitósamente";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permiso  $permiso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permiso $permiso)
    {
        //$permiso = Permiso::withTrashed()->where('id',$id);
        $permiso->forceDelete();

        return "Permiso eliminado Permanentemente";
    }

    public function destroyTemporal(Request $request)
    {
        $permiso = Permiso::withTrashed()->where('id',$request->id);
        $permiso->delete();

        return "Permiso Enviado a Papelera Satisfactoriamente";
    }

    public function restaurar(Request $request)
    {
        $permiso = Permiso::onlyTrashed()->where('id',$request->id);
        $permiso->restore();

        return "Permiso Restaurado Satisfactoriamente";
    }

    public function mostrarModelos()
    {

    }
}
