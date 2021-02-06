<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoMovimiento;

class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipoMovimiento = TipoMovimiento::firstOrCreate(['nombre'=>'DEPÓSITO']);
        $tipoMovimiento = TipoMovimiento::firstOrCreate(['nombre'=>'RETIRO']);
    }
}
