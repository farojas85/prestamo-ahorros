<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['id','persona_id','valoracion_id'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }

    public function valoracion()
    {
        return $this->belongsTo(Valoracion::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
