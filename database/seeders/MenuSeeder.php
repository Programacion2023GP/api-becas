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
        $menuCatalogs = 10;
        $menuRequests = 16;

        // DASHBOARD
        $order = 0;
        DB::table('menus')->insert([ #1
            'menu' => 'Principal',
            'caption' => '',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 1,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #2 Dashboard
            'menu' => 'Tablero',
            'caption' => '',
            'type' => 'item',
            'belongs_to' => $menuDashboard,
            'url' => '/app',
            'icon' => 'IconDashboard',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #3 Solicitud de Beca
            'menu' => 'Solicitud de Beca',
            'caption' => '',
            'type' => 'item',
            'belongs_to' => $menuDashboard,
            'url' => '/app/solicitud-beca',
            'icon' => 'IconFileDollar',
            'order' => $order,
            'created_at' => now(),
        ]);

        // CONFIGURACIONES
        $order = 0;
        DB::table('menus')->insert([ #4
            'menu' => 'Configuraciones',
            'caption' => 'Configuración del sistema y Control de usuarios y roles',
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
            'url' => '/app/configuraciones/menus',
            'icon' => 'IconCategory2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #6 Roles
            'menu' => 'Roles y Permisos',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/app/configuraciones/roles-y-permisos',
            'icon' => 'IconPaperBag',
            'others_permissions' => "Asignar Permisos",
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #7 Usuarios
            'menu' => 'Usuarios',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/app/configuraciones/usuarios',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #8 Respuestas y puntajes
            'menu' => 'Respuestas y Puntajes',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/app/configuraciones/respuestas-y-puntajes',
            'icon' => 'IconAbacus',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #9 Ajustes
            'menu' => 'Ajustes',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/app/configuraciones/ajustes',
            'icon' => 'IconAdjustmentsAlt',
            'order' => $order,
            'created_at' => now(),
        ]);

        // Catalgos
        $order = 0;
        DB::table('menus')->insert([ #10
            'menu' => 'Catalogos',
            'caption' => 'Gestion de Catalogos',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 3,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #11 Escuelas
            'menu' => 'Escuelas',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/app/catalogos/escuelas',
            'icon' => 'IconBuildingSkyscraper',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #12 Niveles
            'menu' => 'Niveles',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/app/catalogos/niveles',
            'icon' => 'IconNumber',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #13 Discapacidades
            'menu' => 'Discapacidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/app/catalogos/discapacidades',
            'icon' => 'IconWheelchair',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #14 Perímetros
            'menu' => 'Perímetros',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/app/catalogos/perimetros',
            'icon' => 'IconRadar2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #15 Comunidades
            'menu' => 'Comunidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/app/catalogos/comunidades',
            'icon' => 'IconMapPin',
            'others_permissions' => "Asignar Perímetro",
            'order' => $order,
            'created_at' => now(),
        ]);

        // Mis Solicitudes
        $order = 0;
        DB::table('menus')->insert([ #16
            'menu' => 'Solicitudes',
            'caption' => 'Solicitudes Realizadas',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 4,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #17 Listado
            'menu' => 'Listado',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/',
            'icon' => 'IconStack3',
            'order' => $order,
            'others_permissions' => "Ver Puntaje, Continuar Solicitud,  Cancelar Solicitud",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #18 Mis Solicitudes
            'menu' => 'Mis Solicitudes',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/mis-solicitudes',
            'icon' => 'IconFileStack',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestByUser',
            // 'others_permissions' => "",
            "read_only" => true,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #19 En Revisión
            'menu' => 'En Revisión',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/en-revision',
            'icon' => 'IconFileSearch',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestInReview',
            'others_permissions' => "Validar Documentos, Corregir Documentos",
            "read_only" => true,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #20 En Evaluación
            'menu' => 'En Evaluación',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/en-evaluacion',
            'icon' => 'IconCheckupList',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestInEvaluation',
            'others_permissions' => "Evaluar Solicitud",
            "read_only" => true,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #21 Aprobadas
            'menu' => 'Aprobadas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/aprobadas',
            'icon' => 'IconFileCheck',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestApproved',
            'others_permissions' => "Pagar Solicitud, Exportar Lista Pública, Exportar Lista Contraloría",
            "read_only" => true,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #22 Pagadas
            'menu' => 'Pagadas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/pagadas',
            'icon' => 'IconFileDollar',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestPayed',
            // 'others_permissions' => "",
            "read_only" => true,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #23 Rechazadas
            'menu' => 'Rechazadas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/rechazadas',
            'icon' => 'IconFileDislike',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestRejected',
            // 'others_permissions' => "",
            "read_only" => true,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #24 Canceladas
            'menu' => 'Canceladas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/app/solicitudes/canceladas',
            'icon' => 'IconFilesOff',
            'order' => $order,
            'show_counter' => true,
            'counter_name' => 'requestCanceled',
            // 'others_permissions' => "",
            "read_only" => true,
            'created_at' => now(),
        ]);
    }
}
