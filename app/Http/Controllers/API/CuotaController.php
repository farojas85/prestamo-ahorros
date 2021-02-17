<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cuota;
use App\Models\Prestamo;

use Carbon\Carbon;
use Illuminate\Http\Request;

class CuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function show(Cuota $cuota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cuota $cuota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cuota  $cuota
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cuota $cuota)
    {
        //
    }

    public function obtenerCuotasPrestamo(Request $request)
    {
        $prestamo = Prestamo::with([
                                'cliente.persona:id,nombres,apellidos',
                                'user.persona:id,nombres,apellidos',
                                'moneda:id,nombre,simbolo',
                                'tasa_interes:id,nombre,valor',
                                'tipo_cuota:id,nombre',
                                'estado_operacion:id,nombre,clase',
                                'forma_pago:id,nombre'])
                    ->where('id',$request->id)->first();

        $presta = new Prestamo();
        $presta->id = $prestamo->id;
        $presta->tipo_cambio = $prestamo->tipo_cambio;
        $presta->fecha = Carbon::parse($prestamo->fecha_prestamo)->format('Y-m-d');
        $presta->monto = number_format($prestamo->monto,2);
        $presta->moneda = $prestamo->moneda->nombre;
        $presta->tasa_interes = $prestamo->tasa_interes->nombre;
        $presta->interes = number_format($prestamo->interes,2);
        $presta->tipo_cuota= $prestamo->tipo_cuota->nombre;
        $presta->numero_cuotas = $prestamo->numero_cuotas;
        $presta->estado = $prestamo->estado_operacion->nombre;
        $presta->estado_clase = $prestamo->estado_operacion->clase;
        $presta->pago = $prestamo->forma_pago->nombre;
        $presta->total = number_format($prestamo->monto + $prestamo->interes,2);

        $saldo = Cuota::where('prestamo_id',$request->id)
                    ->where('estado_operacion_id',2)->sum('monto_cuota');

        $cuotas = Cuota::with('estado_operacion:id,nombre,clase')
                        ->where('prestamo_id',$request->id)->paginate(6);

        $presta->saldo = number_format($saldo,2);

        return response()->json([
            'cliente' => ucwords(strtolower($prestamo->cliente->persona->nombres." ".$prestamo->cliente->persona->apellidos)),
            'cobrador' => ucwords(strtolower($prestamo->user->persona->nombres." ".$prestamo->user->persona->apellidos)),
            'prestamo' => $presta,
            'cuotas' => $cuotas
        ]);
    }

    public function listado(Request $request){
        $cuotas = Cuota::with('estado_operacion:id,nombre,clase')
                        ->where('prestamo_id',$request->id)->paginate(6);

        return response()->json([
            'cuotas' => $cuotas
        ]);
    }
}
