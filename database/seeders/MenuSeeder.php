<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Role;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::select('id')->where('directriz','super-usuario')->first();

        $menu1 = Menu::firstOrCreate(['nombre' => 'Principal','enlace' => 'principal',
                                    'icono' => 'fas fa-th', 'padre_id' => null,'orden' => 0
                                    ]);

        $menu2 = Menu::firstOrCreate(['nombre' => 'Sistema','enlace' => 'sistema',
                                    'icono' => 'fab fa-windows', 'padre_id' => null,'orden' => 0
                                    ])
        ;

        $menu3 = Menu::firstOrCreate(['nombre' => 'Configuracion','enlace' => 'configuracion',
                                    'icono' => 'fas fa-cogs', 'padre_id' => null,'orden' => 0
        ])
        ;

        $menu4 = Menu::firstOrCreate(['nombre' => 'Prestamo','enlace' => 'prestamo',
                                    'icono' => 'fas fa-money-bill-alt', 'padre_id' => null,'orden' => 0
        ])
        ;

        $menu5 = Menu::firstOrCreate(['nombre' => 'Cobranza','enlace' => 'cobranza',
                                    'icono' => 'fas fa-shopping-bag', 'padre_id' => null,'orden' => 0
        ])
        ;

        $role1->menus()->sync([$menu1->id,$menu2->id,$menu3->id,$menu4->id,$menu5->id]);
    }
}
