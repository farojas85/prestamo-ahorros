<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EstadoOperacion;

class EstadoOperacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estado = EstadoOperacion::firstOrCreate(['nombre' => 'Generado' ,'clase'=> 'badge badge-danger']);
        $estado = EstadoOperacion::firstOrCreate(['nombre' => 'Pendiente' ,'clase'=> 'badge badge-warning']);
        $estado = EstadoOperacion::firstOrCreate(['nombre' => 'Cancelado' ,'clase'=> 'badge badge-success']);
        $estado = EstadoOperacion::firstOrCreate(['nombre' => 'Anulado' ,'clase'=> 'badge badge-secondary']);
        $estado = EstadoOperacion::firstOrCreate(['nombre' => 'Eliminado' ,'clase'=> 'badge badge-primary']);
    }
}
