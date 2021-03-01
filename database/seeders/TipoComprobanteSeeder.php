<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoComprobante;

class TipoComprobanteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = TipoComprobante::firstOrCreate(['codigo' => '03','nombre' => 'BOLETA DE VENTA']);
        $tipo = TipoComprobante::firstOrCreate(['codigo' => '01','nombre'=>'FACTURA']);
        $tipo = TipoComprobante::firstOrCreate(['codigo'=>'07','nombre'=>'NOTA DE CRÉDITO']);
        $tipo = TipoComprobante::firstOrCreate(['codigo'=>'08','nombre'=>'NOTA DE DÉBITO']);
        $tipo = TipoComprobante::firstOrCreate(['codigo'=>'09','nombre'=>'GUÍA DE REMISIÓN']);
    }
}
