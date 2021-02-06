<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Valoracion;

class ValoracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $valoracion = Valoracion::firstOrCreate([
            'nombre' => 'Sin Calificación','icono' => 'fas fa-meh-blank',
            'clase' => 'text-gray'
        ]);
        $valoracion = Valoracion::firstOrCreate([
            'nombre' => 'Puntual','icono' => 'fas fa-grin-stars',
            'clase' => 'text-green'
        ]);
        $valoracion = Valoracion::firstOrCreate([
            'nombre' => 'Bueno','icono' => 'fas fa-smile-beam',
            'clase' => 'text-blue'
        ]);
        $valoracion = Valoracion::firstOrCreate([
            'nombre' => 'Regular','icono' => 'fas fa-smile',
            'clase' => 'text-purple'
        ]);
        $valoracion = Valoracion::firstOrCreate([
            'nombre' => 'Moroso','icono' => 'fas fa-sad-tear',
            'clase' => 'text-danger'
        ]);
    }
}
