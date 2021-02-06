<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Valoracion extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['id','nombre','icono','clase'];
    
    public function clientes()
    {
        return $this->hasMany(Cliente::class);
    }
}
