<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FormaPago;

class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formapago = FormaPago::firstOrCreate([ 'nombre' => 'Cobrar Todos los días' ]);
        $formapago = FormaPago::firstOrCreate([ 'nombre' => 'No Cobrar Sábados y Domingos' ]);
        $formapago = FormaPago::firstOrCreate([ 'nombre' => 'No Cobrar Feriados y Domingos' ]);
    }
}
