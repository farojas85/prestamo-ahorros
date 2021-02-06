<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\EntidadFinanciera;

class EntidadFinancieraController extends Controller
{
    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return EntidadFinanciera::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(entidad_financieras.nombre)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return EntidadFinanciera::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(entidad_financieras.nombre)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return EntidadFinanciera::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(entidad_financieras.nombre)"),'like','%'.$buscar.'%');
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
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function show(EntidadFinanciera $entidadFinanciera)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function edit(EntidadFinanciera $entidadFinanciera)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EntidadFinanciera $entidadFinanciera)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EntidadFinanciera  $entidadFinanciera
     * @return \Illuminate\Http\Response
     */
    public function destroy(EntidadFinanciera $entidadFinanciera)
    {
        //
    }
}
