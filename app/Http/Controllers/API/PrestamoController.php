<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use TCPDF;

use App\Models\Prestamo;
use App\Http\Traits\PrestamoTrait;
class PrestamoController extends Controller
{
    use PrestamoTrait;

    public function obtenerInteres(Request $request)
    {
        return $this->calcularInteres($request);
    }

    public function habilitados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Prestamo::paginate($request->pagina);
    }

    public function todos(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Prestamo::withTrashed()->paginate($request->pagina);
    }

    public function eliminados(Request $request)
    {
        $buscar = strtoupper($request->buscar);
        return Prestamo::onlyTrashed()->paginate($request->pagina);
    }

    public function store(Request $request)
    {
        $reglas = [
            'cliente_id' => 'required',
            'fecha_prestamo' => 'required',
            'moneda_id' => 'required',
            'monto' => 'required',
            'tasa_interes_id' => 'required',
            'interes' => 'required',
            'tipo_cuota_id' => 'required',
            'forma_pago_id' => 'required',
            'numero_cuotas' => 'required'
        ];

        $mensaje = [
            'required' => '* Dato Obligatorio'
        ];

        $this->validate($request,$reglas,$mensaje);

        $prestamo = $this->guardarPrestamo(new Prestamo(),$request);

        return response()->json([
            'prestamo' => $prestamo,
            'ok' => 1,
            'mensaje' => 'Préstamo Generado Satisfactoriamente'
        ], 200);
    }

    public function show(Prestamo $prestamo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function edit(Prestamo $prestamo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prestamo $prestamo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Prestamo  $prestamo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prestamo $prestamo)
    {
        //
    }

    public function obtenerTipoCambio()
    {
        $client = new Client();
        return $client->request('GET', 'https://www.deperu.com/api/rest/cotizaciondolar.json');
    }

    public function imprimirDocumento(Request $request)
    {
        $prestamo = Prestamo::with([
                        'moneda:id,nombre','tipo_cuota:id,nombre',
                        'tasa_interes:id,nombre'
                        ])
                        ->where('id',$request->d)->first();
        $this->imprimirPdf($prestamo);
    }
}
