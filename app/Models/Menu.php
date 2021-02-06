<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Traits\MenuTrait;

class Menu extends Model
{
    use HasFactory,SoftDeletes,MenuTrait;

    protected $fillable =['id','nombre','enlace','icono','padre_id','orden'];

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function padre()
    {
        return $this->belongsTo(Menu::class);
    }

    public function menus()
    {
        return $this->hasMany(Menu::class,'padre_id');
    }
}
