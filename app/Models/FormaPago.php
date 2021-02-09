<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPago extends Model
{
    use HasFactory;

    protected $fillable =['id','nombre','descripcion'];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
