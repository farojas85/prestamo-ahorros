<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\MedioPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedioPagoController extends Controller
{
    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return MedioPago::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(medio_pagos.nombre)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return MedioPago::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(medio_pagos.nombre)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return MedioPago::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(medio_pagos.nombre)"),'like','%'.$buscar.'%');
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
     * @param  \App\Models\MedioPago  $medioPago
     * @return \Illuminate\Http\Response
     */
    public function show(MedioPago $medioPago)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MedioPago  $medioPago
     * @return \Illuminate\Http\Response
     */
    public function edit(MedioPago $medioPago)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MedioPago  $medioPago
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MedioPago $medioPago)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MedioPago  $medioPago
     * @return \Illuminate\Http\Response
     */
    public function destroy(MedioPago $medioPago)
    {
        //
    }
}
