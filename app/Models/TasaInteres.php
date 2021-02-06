<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasaInteres extends Model
{
    use HasFactory;
    
    protected $table = 'tasa_interes';

    protected $fillable = ['id','nombre','valor'];

    public function tasa_interes()
    {
        return $this->hasMany(TasaInteres::class);
    }
}
