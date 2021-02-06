<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\PermisoTrait;
use App\Http\Traits\MenuTrait;

class Role extends Model
{
    use SoftDeletes,PermisoTrait,MenuTrait;

    protected $fillable =['id','nombre','directriz'];

    public function users()
    {
        return $this->belongsToMany(User::class,'role_user')->withTimestamps();
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class)->withTimestamps();
    }

    public function menus()
    {
        return $this->belongsToMany(Menu::class)->withTimestamps();
    }
}
