<?php

namespace App\Http\Traits;
use Illuminate\Support\Str;

trait RoleTrait
{

    public function asignarRoles($roles)
    {
        if(is_array($roles))
        {
            $this->roles()->sync($roles);
        } else{
            if(count($this->roles) == 0){
                $this->roles()->attach($roles);
            } else {
                foreach($this->roles as $role)
                {
                    if($role->id != $roles)
                    {
                        $this->roles()->attach($roles);
                    }
                }
            }
        }
    }
    public function eliminarRoles($roles)
    {
        $this->roles()->detach($roles);
    }

    public function eliminarRolesTodo()
    {
        $this->roles()->detach();
    }

    public function tieneRol($role)
    {
        $directriz = Str::slug($role);

        return (bool) $this->roles()->where('diretriz', $directriz)->count();
    }

    public function tieneAlgunRol($roles)
    {
        foreach ($roles as $role) {
            if ($this->tieneRole($role)) {
                return true;
            }
        }
        return false;
    }
}
