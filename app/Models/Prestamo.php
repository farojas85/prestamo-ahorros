<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','cliente_id', 'user_id','moneda_id','tasa_interes_id',
        'fecha_prestamo','monto','interes','tipo_cuota_id',
        'numero_cuotas','dias_morosos','forma_pago_id',
        'estado_operacion_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function tasa_interes()
    {
        return $this->belongsTo(TasaInteres::class);
    }

    public function tipo_cuota()
    {
        return $this->belongsTo(TipoCuota::class);
    }

    public function estado_operacion()
    {
        return $this->belongsTo(EstadoOperacion::class);
    }

    public function forma_pago()
    {
        return $this->belongsTo(FormaPago::class);
    }

    public function cuotas()
    {
        return $this->hasMany(Cuota::class);
    }
}
