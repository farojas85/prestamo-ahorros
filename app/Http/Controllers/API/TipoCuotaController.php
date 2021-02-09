<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTipoCuotaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoCuota;

class TipoCuotaController extends Controller
{
    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TipoCuota::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tipo_cuotas.nombre)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TipoCuota::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tipo_cuotas.nombre)"),'like','%'.$buscar.'%');
                        }
                    )
                    ->withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return TipoCuota::where(function($query) use($buscar) {
                        $query->where(DB::Raw("upper(tipo_cuotas.nombre)"),'like','%'.$buscar.'%');
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
    public function store(StoreTipoCuotaRequest $request)
    {
        $validado = $request->validated();

        //Insertamos el Rol
        $tipo_cuota = TipoCuota::create([
            'nombre' => $request->nombre,
            'dias' => $request->dias,
        ]);

        return "Tipo Cuota registrado Exitósamente";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TipoCuota  $tipoCuota
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return TipoCuota::select('id','nombre','dias')->where('id',$id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TipoCuota  $tipoCuota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $tipo_cuota =  $this->show($request->id);

        $tipo_cuota->nombre = $request->nombre;
        $tipo_cuota->dias = $request->dias;
        $tipo_cuota->save();

        return "Tipo Cuota Modificado Exitósamente";
    }

    public function destroy($id)
    {
        $tipoCuota = TipoCuota::withTrashed()->where('id',$id);
        $tipoCuota->forceDelete();

        return "Tipo Cuota eliminado Permanentemente";
    }

    public function destroyTemporal(Request $request)
    {
        $tipoCuota = TipoCuota::withTrashed()->where('id',$request->id);
        $tipoCuota->delete();

        return "Tipo Cuota Enviado a Papelera Satisfactoriamente";
    }

    public function restaurar(Request $request)
    {
        $tipoCuota = TipoCuota::onlyTrashed()->where('id',$request->id);
        $tipoCuota->restore();

        return "Tipo Cuota Restaurado Satisfactoriamente";
    }

    public function listar()
    {
        return TipoCuota::select('id','nombre','dias')->get();
    }
}
