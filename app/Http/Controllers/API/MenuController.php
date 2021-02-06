<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
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
        return Menu::where(function($query) use($buscar){
                        $query->where(DB::Raw("lower(nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("lower(enlace)"),'like','%'.$buscar.'%');
                    })
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtolower($request->buscar);
        return Menu::where(function($query) use($buscar){
                            $query->where(DB::Raw("lower(nombre)"),'like','%'.$buscar.'%')
                                ->orWhere(DB::Raw("lower(enlace)"),'like','%'.$buscar.'%');
                        })
                        ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtolower($request->buscar);
        return Menu::where(function($query) use($buscar){
                            $query->where(DB::Raw("lower(nombre)"),'like','%'.$buscar.'%')
                                ->orWhere(DB::Raw("lower(enlace)"),'like','%'.$buscar.'%');
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
            'enlace' => 'string|max:191|unique:menus'
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo 191 caracteres',
            'unique' => 'el Enlace ya está en uso'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        $menu = new Menu();
        $menu->nombre = $request->nombre;
        $menu->enlace = $request->enlace;
        $menu->icono = $request->icono;

        if($request->padre_id !='' || $request->padre_id != null)
        {
            $menu->padre_id = $request->padre_id;
            $menu->orden = Menu::maximoHijoId($request->padre_id);
        } else {
            $menu->orden = Menu::maximoPadreId();
        }

        $menu->save();

        return "Menú Registrado Satisfactoriamente";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Menu::where('id',$id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //Definimos las reglas de Validación
        $reglas = [
            'nombre' => 'required|string|max:191',
            'enlace' => 'string|max:191|unique:menus,enlace,'.$request->id
        ];
        //Agregamos Mensajes para las reglas
        $mensajes = [
            'required' => '* Dato Obligatorio',
            'max' => 'Ingrese Máximo 191 caracteres',
            'unique' => 'el Enlace ya está en uso'
        ];
        //procesamos la validación
        $this->validate($request,$reglas,$mensajes);

        $menu = Menu::where('id',$request->id)->first();

        $menu->nombre = $request->nombre;
        $menu->enlace = $request->enlace;
        $menu->icono = $request->icono;

        if($request->padre_id !='' || $request->padre_id != null)
        {
            if($menu->padre_id != $request->padre_id)
            {
                $menu->padre_id = $request->padre_id;
                $menu->orden = Menu::maximoHijoId($request->padre_id);
            }
        } else {
            if($menu->padre_id != $request->padre_id)
            {
                $menu->orden = Menu::maximoPadreId();
            }
        }

        $menu->save();

        return "Menú Actualizado Satisfactoriamente";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::withTrashed()->where('id',$id);
        $menu->forceDelete();

        return "Menú eliminado Permanentemente";
    }

    public function destroyTemporal(Request $request)
    {
        $menu = menu::withTrashed()->where('id',$request->id);
        $menu->delete();

        return "Menú Enviado a Papelera Satisfactoriamente";
    }

    public function restaurar(Request $request)
    {
        $menu = Menu::onlyTrashed()->where('id',$request->id);
        $menu->restore();

        return "Menu Restaurado Satisfactoriamente";
    }

    public function obtenerPadres()
    {
        return Menu::obtenerPadres();
    }
}
