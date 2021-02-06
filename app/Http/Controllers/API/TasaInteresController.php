<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TasaInteres;

class TasaInteresController extends Controller
{
    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TasaInteres::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tasa_interes.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(tasa_interes.valor)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TasaInteres::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tasa_interes.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(tasa_interes.valor)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TasaInteres::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tasa_interes.nombre)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(tasa_interes.valor)"),'like','%'.$buscar.'%');
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
     * @param  \App\Models\TasaInteres  $tasaInteres
     * @return \Illuminate\Http\Response
     */
    public function show(TasaInteres $tasaInteres)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TasaInteres  $tasaInteres
     * @return \Illuminate\Http\Response
     */
    public function edit(TasaInteres $tasaInteres)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TasaInteres  $tasaInteres
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TasaInteres $tasaInteres)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TasaInteres  $tasaInteres
     * @return \Illuminate\Http\Response
     */
    public function destroy(TasaInteres $tasaInteres)
    {
        //
    }
}
