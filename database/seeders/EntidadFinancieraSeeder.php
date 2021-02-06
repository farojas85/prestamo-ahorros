<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EntidadFinanciera;

class EntidadFinancieraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '98',
                        'nombre' => 'MI EMPRESA']);
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '01',
                        'nombre' => 'BANCO CENTRAL DE RESERVA DEL PERU']);
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '02',
                        'nombre' => 'BANCO DE CRÉDITO DEL PERU']);
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '03',
                        'nombre' => 'INTERBANK PERÚ']);
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '09',
                        'nombre' => 'SCOTIABANK PERÚ']);
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '11',
                        'nombre' => 'BANCO CONTINENTAL']);
        $entidadFinanciera = EntidadFinanciera::firstOrCreate(['codigo' => '18',
                        'nombre' => 'BANCO DE LA NACIÓN']);
    }
}
