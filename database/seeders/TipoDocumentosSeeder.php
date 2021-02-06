<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDocumento;

class TipoDocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo = TipoDocumento::firstOrCreate(['tipo' =>'01' ,'nombre_largo' => 'D.N.I O LIBRETA ELECTORAL',
                                                'nombre_corto' => 'D.N.I/L.E.','longitud' => 8])
        ;
        $tipo = TipoDocumento::firstOrCreate(['tipo' =>'04' ,'nombre_largo' => 'CARNET DE EXTRANJERIA',
                                                'nombre_corto' => 'CARNET EXT.','longitud' => 12])
        ;
        $tipo = TipoDocumento::firstOrCreate(['tipo' =>'06' ,'nombre_largo' => 'REG. UNICO DE CONTRIBUYENTES',
                                                'nombre_corto' => 'R.U.C','longitud' => 11])
        ;
        $tipo = TipoDocumento::firstOrCreate(['tipo' =>'07' ,'nombre_largo' => 'PASAPORTE',
                                                'nombre_corto' => 'PASAPORTE','longitud' => 12])
        ;
        $tipo = TipoDocumento::firstOrCreate(['tipo' =>'11' ,'nombre_largo' => 'PARTIDA DE NACIMIENTO - IDENTIDAD',
                                                'nombre_corto' => 'P. NAC.','longitud' => 15])
        ;
        $tipo = TipoDocumento::firstOrCreate(['tipo' =>'00' ,'nombre_largo' => 'OTROS',
                                                'nombre_corto' => 'OTROS','longitud' => 15])
        ;

    }
}
