<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoDocumento;
use Carbon\Carbon;

class TipoDocumentoController extends Controller
{
    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TipoDocumento::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tipo_documentos.nombre_corto)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(tipo_documentos.nombre_largo)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TipoDocumento::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tipo_documentos.nombre_corto)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(tipo_documentos.nombre_largo)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TipoDocumento::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tipo_documentos.nombre_corto)"),'like','%'.$buscar.'%')
                            ->orWhere(DB::Raw("upper(tipo_documentos.nombre_largo)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->onlyTrashed()->paginate($request->pagina);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoDocumento  $tipoDocumento
     * @return \Illuminate\Http\Response
     */
    public function show(TipoDocumento $tipoDocumento)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoDocumento  $tipoDocumento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoDocumento $tipoDocumento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TipoDocumento  $tipoDocumento
     * @return \Illuminate\Http\Response
     */
    public function destroy(TipoDocumento $tipoDocumento)
    {
        //
    }

    public function listar()
    {
        return TipoDocumento::select('id','nombre_corto','nombre_largo')->get();
    }

    
}
