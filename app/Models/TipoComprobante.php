<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoComprobante extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['id','codigo','nombre'];

    /**
     * Get all of the comments for the TipoComprobante
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function series(): HasMany
    {
        return $this->hasMany(Serie::class);
    }
}
