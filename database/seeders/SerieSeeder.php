<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoComprobante;
use App\Models\Serie;

class SerieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $boleta = TipoComprobante::select('id')->where('codigo','03')->first();
        $factura = TipoComprobante::select('id')->where('codigo','01')->first();

        $serie = Serie::firstOrCreate(['tipo_comprobante_id' =>$boleta->id,'nombre' => 'B001' ]);
        $serie = Serie::firstOrCreate(['tipo_comprobante_id' =>$factura->id,'nombre' => 'F001' ]);

    }
}
