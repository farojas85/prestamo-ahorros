<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

use App\Models\Cuota;
use App\Models\Prestamo;
use App\Models\TipoCuota;
use App\Models\TasaInteres;

trait PrestamoTrait
{
    public function obtenerAdminHabilitados(Request $request)
    {
        return Prestamo::with([
            'cliente' => function($query){
                $query->select('id','persona_id','valoracion_id');
            },
            'cliente.persona' => function($query){
                $query->select('id','nombres','apellidos');
            },
            'cliente.valoracion' => function( $query) {
                $query->select('id','nombre','icono','clase');
            },
            'user' => function($query){
                $query->select('id','persona_id');
            },
            'user.persona' => function($query){
                $query->select('id','nombres','apellidos');
            },
            'estado_operacion' => function($query){
                $query->select('id','nombre','clase');
            }
        ])
        ->select(
            'id','fecha_prestamo','deleted_at','cliente_id','user_id',
            'monto','interes','estado_operacion_id')
        ->paginate($request->pagina);
    }

    public function obtenerUserHabilitados(Request $request)
    {
        return Prestamo::with([
            'cliente' => function($query){
                $query->select('id','persona_id','valoracion_id');
            },
            'cliente.persona' => function($query){
                $query->select('id','nombres','apellidos');
            },
            'cliente.valoracion' => function( $query) {
                $query->select('id','nombre','icono','clase');
            },
            'user' => function($query){
                $query->select('id','persona_id');
            },
            'user.persona' => function($query){
                $query->select('id','nombres','apellidos');
            },
            'estado_operacion' => function($query){
                $query->select('id','nombre','clase');
            }
        ])
        ->select(
            'id','fecha_prestamo','deleted_at','cliente_id','user_id',
            'monto','interes','estado_operacion_id')
        ->where('prestamos.user_id',$request->usuario)
        ->paginate($request->pagina);
    }

    public function calcularInteres($request)
    {
        $tasaInteres = TasaInteres::select('valor')->where('id',$request->tasa)->first();
        return $request->monto*$tasaInteres->valor;
    }

    public function guardarPrestamo($prestamo,$request)
    {
        $prestamo->cliente_id = $request->cliente_id;
        $prestamo->user_id = $request->usuario_id;
        $prestamo->fecha_prestamo = $request->fecha_prestamo;
        $prestamo->moneda_id = $request->moneda_id;
        $prestamo->tipo_cambio = ($request->tipo_cambio==null) ? 0.00 : $request->tipo_cambio;
        $prestamo->monto = $request->monto;
        $prestamo->tasa_interes_id = $request->tasa_interes_id;
        $prestamo->interes = $request->interes;
        $prestamo->tipo_cuota_id = $request->tipo_cuota_id;
        $prestamo->numero_cuotas = $request->numero_cuotas;
        $prestamo->forma_pago_id = $request->forma_pago_id;
        $prestamo->estado_operacion_id = (!$request->id) ? 1 : $request->estado_operacion_id;
        $prestamo->dias_morosos = (!$request->id) ? 0 : $request->dias_morosos;
        $prestamo->save();

        if(!$request->id)
        {
            $this->generarCuotas($prestamo);
        }

        return $prestamo;
    }

    public function generarCuotas($prestamo)
    {
        $fechaHoy=Carbon::now();
        $fechaInicio = $fechaHoy;
        $monto_inicial =$prestamo->monto + $prestamo->interes;
        $cuota_monto = round($monto_inicial/$prestamo->numero_cuotas,2);
        for($x=1;$x<=$prestamo->numero_cuotas;$x++)
        {
            $tipoCuota = $this->obtenerTipoCuota($prestamo->tipo_cuota_id);
            $fechaSiguiente = $this->obtenerFechaCuota($fechaInicio,$tipoCuota,$prestamo->forma_pago_id);

            $cuota = new Cuota();
            $cuota->prestamo_id =$prestamo->id;
            $cuota->numero_cuota = $x;
            $cuota->monto_cuota = $cuota_monto;
            $cuota->saldo = $monto_inicial - $cuota_monto;
            $cuota->fecha_vencimiento = $fechaSiguiente->format('Y-m-d');
            $cuota->estado_operacion_id = 2;
            $cuota->save();

            $monto_inicial -= $cuota_monto;
            $fechaInicio = $fechaSiguiente;
        }
    }

    public function obtenerTipoCuota($tipoCuota)
    {
        return TipoCuota::select('dias')->where('id',$tipoCuota)->first();
    }

    public function obtenerFechaCuota($fechaHoy,$tipoCuota,$forma_pago)
    {
        $fechaSiguiente = $fechaHoy;
        if($tipoCuota->dias == 1) {
            $fechaSiguiente = $fechaHoy->addDay();
        } else {
            $fechaSiguiente = $fechaHoy->addDays($tipoCuota->dias);
        }

        if($forma_pago == 2)
        {
            $eco = true;
            while($eco)
            {
                $diaSemana = $fechaSiguiente->dayOfWeek;
                if($diaSemana == 0 || $diaSemana == 6)
                {
                    $fechaSiguiente = $fechaSiguiente->addDay();
                } else {
                    $eco=false;
                }
            }
        }

        return $fechaSiguiente;
    }

    public function imprimirPdf($prestamo)
    {
        $pdf = new Fpdf('P','mm','A4');

        $pdf->addPage();

        $pdf->image('images/ibizza_Group_pdf.jpg',55,5,35,25);

        $pdf->SetFont('Helvetica','B',16);
        $pdf->SetXY(92,8);
        $pdf->Cell(60,5,env('EMPRESA'),0,1,'C',0);
        $pdf->SetFont('Helvetica','',11);
        $pdf->SetXY(92,13);
        $pdf->Cell(60,5,env('RUC'),0,1,'C',0);
        $pdf->SetFont('Helvetica','',10);
        $pdf->SetXY(92,18);
        $pdf->Cell(60,5,env('DIRECCION'),0,1,'C',0);
        $pdf->SetFont('Helvetica','',9);
        $pdf->SetXY(92,23);
        $pdf->Cell(60,5,utf8_decode(env('UBIGEO')),0,1,'C',0);

        $pdf->SetXY(10,35);
        $pdf->SetFont('Helvetica','B',16);
        $pdf->Cell(190,7,utf8_decode('PRÉSTAMO EFECTIVO'),0,1,'C',0);

        $pdf->Line(10,44,200,44);

        $pdf->Rect(10, 48, 190, 28);

        //DESCRIPCIÓN 1
        $pdf->SetFont('Helvetica','B',10);
        $pdf->SetXY(12,50);
        $pdf->Cell(32,5,utf8_decode('Fecha Préstamo: '),0,1,'L',0);
        $pdf->SetXY(12,56);
        $pdf->Cell(32,5,utf8_decode('Moneda: '),0,1,'L',0);
        $pdf->SetXY(12,62);
        $pdf->Cell(32,5,utf8_decode('Frecuencia Cuota: '),0,1,'L',0);
        $pdf->SetXY(12,68);
        $pdf->Cell(32,5,utf8_decode('N° Cuotas: '),0,1,'L',0);

        //DETALLE 1
        $pdf->SetFont('Helvetica','',10);
        $pdf->SetXY(45,50);
        $pdf->Cell(32,5,Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y'),0,1,'L',0);
        $pdf->SetXY(45,56);
        $pdf->Cell(32,5,strtoupper($prestamo->moneda->nombre),0,1,'L',0);
        $pdf->SetXY(45,62);
        $pdf->Cell(32,5,strtoupper($prestamo->tipo_cuota->nombre),0,1,'L',0);
        $pdf->SetXY(45,68);
        $pdf->Cell(32,5,$prestamo->numero_cuotas,0,1,'L',0);


        //DESCRIPCIÓN 2
        $pdf->SetFont('Helvetica','B',10);
        $pdf->SetXY(130,50);
        $pdf->Cell(32,5,utf8_decode('Monto Préstamo: '),0,1,'L',0);
        $pdf->SetXY(130,56);
        $pdf->Cell(32,5,utf8_decode('Tasa Interés: '),0,1,'L',0);
        $pdf->SetXY(130,62);
        $pdf->Cell(32,5,utf8_decode('Interes: '),0,1,'L',0);
        $pdf->SetXY(130,68);
        $pdf->Cell(32,5,utf8_decode('Total a Pagar: '),0,1,'L',0);


        //DETALLE 2
        $pdf->SetFont('Helvetica','',10);
        $pdf->SetXY(163,50);
        $pdf->Cell(32,5,number_format($prestamo->monto,2),0,1,'R',0);
        $pdf->SetXY(163,56);
        $pdf->Cell(32,5,strtoupper($prestamo->tasa_interes->nombre),0,1,'R',0);
        $pdf->SetXY(163,62);
        $pdf->Cell(32,5,number_format($prestamo->interes,2),0,1,'R',0);
        $pdf->SetXY(163,68);
        $pdf->Cell(32,5,number_format($prestamo->monto+$prestamo->interes,2),0,1,'R',0);

        $pdf->Line(10,80,200,80);

        $pdf->SetXY(10,81);
        $pdf->SetFont('Helvetica','B',11);
        $pdf->Cell(190,7,utf8_decode('CRONOGRAMA DE CUOTAS'),0,1,'C',0);

        //CABECERA CUOTAS
        $pdf->SetLineWidth(0.6);
        $pdf->Rect(45, 89, 120, 7);
        $pdf->SetLineWidth(0.1);
        $pdf->SetFillColor(190,190,190);
        $pdf->SetFont('Helvetica','B',10);

        $pdf->SetXY(45,89);
        $pdf->Cell(15,7,'Cuota',1,1,'C',1);
        $pdf->SetXY(60,89);
        $pdf->Cell(25,7,'Fecha Venc.',1,1,'C',1);
        $pdf->SetXY(85,89);
        $pdf->Cell(25,7,'Monto Cuota',1,1,'C',1);
        $pdf->SetXY(110,89);
        $pdf->Cell(25,7,'Saldo',1,1,'C',1);
        $pdf->SetXY(135,89);
        $pdf->Cell(30,7,'Estado',1,1,'C',1);


        $pdf->SetFillColor(255,255,255);

        $pdf->SetFont('Helvetica','',10);

        $posY=96;

        foreach($prestamo->cuotas as $cuota)
        {
            //NÚMERO CUOTA
            $pdf->SetXY(45,$posY);
            $pdf->Cell(15,7,$cuota->numero_cuota,1,1,'C',0);
            //FECHA VENCIMIENTO
            $pdf->SetXY(60,$posY);
            $fecha_venc = Carbon::parse($cuota->fecha_vencimiento)->format('d/m/Y');
            $pdf->Cell(25,7,$fecha_venc,1,1,'C',0);
            //MONTO CUOTAs
            $pdf->SetXY(85,$posY);
            $pdf->Cell(25,7,number_format($cuota->monto_cuota,2),1,1,'C',0);
            //SALDO
            $pdf->SetXY(110,$posY);
            $pdf->Cell(25,7,number_format($cuota->saldo,2),1,1,'C',0);
            //ESTADO
            if($cuota->estado_operacion->nombre=='Pendiente')
            {
                $pdf->SetTextColor(255,0,0);
            }
            $pdf->SetXY(135,$posY);
            $pdf->Cell(30,7,$cuota->estado_operacion->nombre,1,1,'C',0);
            $posY +=7;
            $pdf->SetTextColor(0,0,0);
        }
        $pdf->output();
        exit;
    }
}
