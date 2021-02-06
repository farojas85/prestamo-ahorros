<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedioPago;

class MedioPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medioPago = MedioPago::firstOrCreate(['codigo' => '008','nombre' => 'EFECTIVO']);
        $medioPago = MedioPago::firstOrCreate(['codigo' => '001','nombre' => 'DEPOSITO EN CUENTA']);
        $medioPago = MedioPago::firstOrCreate(['codigo' => '002','nombre' => 'GIRO']);
        $medioPago = MedioPago::firstOrCreate(['codigo' => '003','nombre' => 'TRANSFERENCIA DE FONDOS']);
        $medioPago = MedioPago::firstOrCreate(['codigo' => '005','nombre' => 'TARJETA DEBITO']);
        $medioPago = MedioPago::firstOrCreate(['codigo' => '006','nombre' => 'TARJETA CRÉDITO']);
        $medioPago = MedioPago::firstOrCreate(['codigo' => '102','nombre' => 'CHEQUES BANCARIOS']);
    }
}
