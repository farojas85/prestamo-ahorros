<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Moneda;
class MonedaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $moneda = Moneda::firstOrCreate([
            'codigo' => 'PEN','nombre' => 'Soles',
            'pais' => 'Perú','simbolo' => null
        ]);
        $moneda = Moneda::firstOrCreate([
            'codigo' => 'USD','nombre' => 'US Dollar',
            'pais' => 'Estados Unidos','simbolo' => 'fas fa-dollar-sign'
        ]);
        $moneda = Moneda::firstOrCreate([
            'codigo' => 'EUR','nombre' => 'Euro',
            'pais' => 'Unión Europea','simbolo' =>'fas fa-euro-sign'
        ]);
    }
}
