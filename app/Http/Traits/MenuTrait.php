<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

trait MenuTrait
{
    public static function obtenerPadres()
    {
        return Menu::select('id','nombre')->whereNull('padre_id')
                    ->orderby('orden','asc')->get();
    }

    public static function maximoPadreId()
    {
        $maxOrden = Menu::whereNull('padre_id')->max('orden');
        return ($maxOrden == null || $maxOrden == '') ? 0 : $maxOrden + 1;
    }

    public static function maximoHijoId($padre_id)
    {
        $maxOrden = Menu::where('padre_id',$padre_id)->max('orden');
        return ($maxOrden == null || $maxOrden == '') ? 0 : $maxOrden + 1;
    }

    public static function sideBarMenu($role_id)
    {
        return $padres = Menu::join('menu_role as mr','menus.id','=','mr.menu_id')
                            ->select('menus.id','menus.nombre','menus.enlace','menus.icono',
                                    'menus.padre_id','menus.orden')
                            ->where('mr.role_id',$role_id)
                            ->whereNull('menus.padre_id')
                            ->orderBy('orden','asc')
                            ->get();

    }

    public function asignarMenus($menus)
    {
        if(is_array($menus))
        {
            $this->menus()->sync($menus);
        } else{
            if(count($this->menus) == 0){
                $this->menus()->attach($menus);
            } else {
                foreach($this->menus as $menu)
                {
                    if($menu->id != $menus)
                    {
                        $this->menus()->attach($menus);
                    }
                }
            }
        }
    }

    public function obtenerMenus($roles)
    {
        return Menu::join('menu_role as mr','menus.id','=','mr.menu_id')
                        ->select('menus.id','menus.nombre','menus.enlace','menus.icono')
                        ->where('mr.role_id',$roles)
                        ->orderBy('menus.id','asc')->get();
    }
}
