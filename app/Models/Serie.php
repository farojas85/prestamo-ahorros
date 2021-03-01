<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable =['id','tipo_comprobante_id','nombre'];

    /**
     * Get the user that owns the Serie
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo_comprobante(): BelongsTo
    {
        return $this->belongsTo(TipoComprobante::class);
    }
}
