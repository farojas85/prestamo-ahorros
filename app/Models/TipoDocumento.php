<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDocumento extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable=['id','codigo','nombre_corto','nombre_largo','longitud'];
    
    public function personas()
    {
        return $this->hasMany(Persona::class);
    }
}
