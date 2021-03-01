<?php
namespace App\Http\Traits;

use Illuminate\Support\Str;

trait HelperTrait
{
    public function obtenerMayuscula(string $cadena) :string
    {
        return Str::upper($cadena);
    }
}
