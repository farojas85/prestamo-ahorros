<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;

    public function prestamo()
    {
        return $this->belongsTo(Prestamo::class);
    }
    public function estado_operacion()
    {
        return $this->belongsTo(EstadoOperacion::class);
    }
}
