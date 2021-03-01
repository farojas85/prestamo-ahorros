<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cliente;
use App\Http\Traits\HelperTrait;

trait ClienteTrait
{
    use HelperTrait;

    public function buscarCliente(Request $request)
    {
        $buscar = $this->obtenerMayuscula($request->buscar);

        return Cliente::with('persona:id,nombres,apellidos,numero_documento')
                    ->select('id','persona_id')
                    ->where(function($query) use($buscar){
                        $query->whereHas('persona',function($q) use($buscar){
                            $q->where(DB::Raw("upper(nombres)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(apellidos)"),'like','%'.$buscar.'%');
                        });
                    })->get();
    }
}
