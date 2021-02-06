<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            TipoDocumentosSeeder::class,
            RolesSeeder::class,
            UserAdminSeeder::class,
            MenuSeeder::class,
            PermisoSeeder::class,
            TipoCuotaSeeder::class,
            ValoracionSeeder::class,
            TasaInteresSeeder::class,
            MonedaSeeder::class,
            MedioPagoSeeder::class,
            EntidadFinancieraSeeder::class,
            TipoMovimientoSeeder::class,
            EstadoOperacionSeeder::class
        ]);
    }
}
