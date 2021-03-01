<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function ultimaCuotaPendiente()
    {
        return Cuota::select('prestamo_id',
                DB::Raw("min(fecha_vencimiento) as fecha_cuota"))
                ->where('estado_operacion_id',2)
                ->groupBy('prestamo_id');
    }
}
