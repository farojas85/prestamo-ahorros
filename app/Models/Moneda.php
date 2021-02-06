<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Moneda extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['id','codigo','nombre','pais','simbolo'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
