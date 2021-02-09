<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Moneda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonedaController extends Controller
{
    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Moneda::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(monedas.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(monedas.pais)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Moneda::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(monedas.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(monedas.pais)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Moneda::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(monedas.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(monedas.pais)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->onlyTrashed()->paginate($request->pagina);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function show(Moneda $moneda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function edit(Moneda $moneda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Moneda $moneda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Moneda  $moneda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Moneda $moneda)
    {
        //
    }

    public function listar()
    {
        return Moneda::select('id','nombre','codigo','simbolo','pais')->get();
    }
}
