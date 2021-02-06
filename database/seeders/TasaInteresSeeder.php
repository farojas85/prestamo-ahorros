<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TasaInteres;

class TasaInteresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tasaInterese = TasaInteres::firstOrCreate(['nombre' => '10 %','valor' => 0.10]);
        $tasaInterese = TasaInteres::firstOrCreate(['nombre' => '15 %','valor' => 0.15]);
        $tasaInterese = TasaInteres::firstOrCreate(['nombre' => '20 %','valor' => 0.20]);
        $tasaInterese = TasaInteres::firstOrCreate(['nombre' => '25 %','valor' => 0.25]);
    }
}
