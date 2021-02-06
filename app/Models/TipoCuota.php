<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCuota extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['id','nombre','dias'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
