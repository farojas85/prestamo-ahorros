<?php

namespace App\Models;

use App\Http\Traits\RoleTrait;
use App\Http\Traits\PermisoTrait;
use App\Http\Traits\MenuTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use SoftDeletes,Notifiable,HasApiTokens,RoleTrait,PermisoTrait,MenuTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'persona_id', 'name', 'email', 'password', 'foto',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'role_user')->withTimestamps();
    }

    public function clientes()
    {
        return $this->belongsToMany(Cliente::class)->withTimestamps();
    }
}
