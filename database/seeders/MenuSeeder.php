<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menuDashboard = 1;
        $menuAdmin = 4;
        $menuCatalogs = 8;
        $menuRequests = 14;

        // DASHBOARD
        $order = 0;
        DB::table('menus')->insert([ #1
            'menu' => 'Dashboard',
            'caption' => '',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 1,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #2 Dashboard
            'menu' => 'Dashboard',
            'caption' => '',
            'type' => 'item',
            'belongs_to' => $menuDashboard,
            'url' => '/admin',
            'icon' => 'IconDashboard',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #3 Solicitud de Beca
            'menu' => 'Solicitu de Beca',
            'caption' => '',
            'type' => 'item',
            'belongs_to' => $menuDashboard,
            'url' => '/admin/solicitud-beca',
            'icon' => 'IconFileDollar',
            'order' => $order,
            'created_at' => now(),
        ]);

        // ADMINISTRATIVO
        $order = 0;
        DB::table('menus')->insert([ #4
            'menu' => 'Administrativo',
            'caption' => 'Control de usuarios y roles',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 2,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #5 Menus
            'menu' => 'Menus',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/menus',
            'icon' => 'IconCategory2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #6 Roles
            'menu' => 'Roles',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/roles-y-permisos',
            'icon' => 'IconPaperBag',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #7 Usuarios
            'menu' => 'Usuarios',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/usuarios',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);

        // Catalgoos
        $order = 0;
        DB::table('menus')->insert([ #8
            'menu' => 'Catalogos',
            'caption' => 'Gestion de Catalogos',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 3,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #9 Escuelas
            'menu' => 'Escuelas',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/escuelas',
            'icon' => 'IconBuildingSkyscraper',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #10 Niveles
            'menu' => 'Niveles',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/niveles',
            'icon' => 'IconNumber',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #11 Discapacidades
            'menu' => 'Discapacidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/discapacidades',
            'icon' => 'IconWheelchair',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #12 Perímetros
            'menu' => 'Perímetros',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/perimetros',
            'icon' => 'IconRadar2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #13 Comunidades
            'menu' => 'Comunidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/comunidades',
            'icon' => 'IconMapPin',
            'order' => $order,
            'created_at' => now(),
        ]);

        // Mis Solicitudes
        $order = 0;
        DB::table('menus')->insert([ #14
            'menu' => 'Solicitudes',
            'caption' => 'Solicitudes Realizadas',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 4,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #15 Listado
            'menu' => 'Listado',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/',
            'icon' => 'IconStack3',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #16 Mis Solicitudes
            'menu' => 'Mis Solicitudes',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/mis-solicitudes',
            'icon' => 'IconFileStack',
            'order' => $order,
            'created_at' => now(),
        ]);
    }
}
