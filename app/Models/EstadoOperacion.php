<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoOperacion extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['id','nombre','clase'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function cuotas()
    {
        return $this->hasMany(EstadoOperacion::class);
    }
}
