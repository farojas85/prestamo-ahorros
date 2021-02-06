<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoCuota;

class TipoCuotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoCuota = TipoCuota::firstOrCreate(['nombre' => 'Diario','dias' => 1]);
        $tipoCuota = TipoCuota::firstOrCreate(['nombre' => 'Semanal','dias' => 7]);
        $tipoCuota = TipoCuota::firstOrCreate(['nombre' => 'Quincenal','dias' => 15]);
        $tipoCuota = TipoCuota::firstOrCreate(['nombre' => 'Mensual','dias' => 30]);
        $tipoCuota = TipoCuota::firstOrCreate(['nombre' => 'Anual','dias' => 365]);
    }
}
