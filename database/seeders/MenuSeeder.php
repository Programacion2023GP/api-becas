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
        $menuCatalogs = 9;
        $menuRequests = 15;

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
            'url' => '/admin/configuraciones/menus',
            'icon' => 'IconCategory2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #6 Roles
            'menu' => 'Roles y Permisos',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/configuraciones/roles-y-permisos',
            'icon' => 'IconPaperBag',
            'others_permissions' => "6@Asignar Permisos",
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #7 Usuarios
            'menu' => 'Usuarios',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/configuraciones/usuarios',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #8 Respuestas y puntajes
            'menu' => 'Respuestas y Puntajes',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/configuraciones/respuestas-y-puntajes',
            'icon' => 'IconAbacus',
            'order' => $order,
            'created_at' => now(),
        ]);

        // Catalgos
        $order = 0;
        DB::table('menus')->insert([ #9
            'menu' => 'Catalogos',
            'caption' => 'Gestion de Catalogos',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 3,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #10 Escuelas
            'menu' => 'Escuelas',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/escuelas',
            'icon' => 'IconBuildingSkyscraper',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #11 Niveles
            'menu' => 'Niveles',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/niveles',
            'icon' => 'IconNumber',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #12 Discapacidades
            'menu' => 'Discapacidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/discapacidades',
            'icon' => 'IconWheelchair',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #13 Perímetros
            'menu' => 'Perímetros',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/perimetros',
            'icon' => 'IconRadar2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #14 Comunidades
            'menu' => 'Comunidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/comunidades',
            'icon' => 'IconMapPin',
            'others_permissions' => "14@Asignar Perímetro",
            'order' => $order,
            'created_at' => now(),
        ]);

        // Mis Solicitudes
        $order = 0;
        DB::table('menus')->insert([ #15
            'menu' => 'Solicitudes',
            'caption' => 'Solicitudes Realizadas',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 4,
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #16 Listado
            'menu' => 'Listado',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/',
            'icon' => 'IconStack3',
            'order' => $order,
            'others_permissions' => "16@Validar Documentos, 16@Continuar, 16@Evaluar, 16@Aprobar, 16@Rechazar, 16@Pagar, 16@Cancelar",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #17 Mis Solicitudes
            'menu' => 'Mis Solicitudes',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/mis-solicitudes',
            'icon' => 'IconFileStack',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=> 'requestByUser',
            'others_permissions' => "17@Cancelar",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #18 En Revisión
            'menu' => 'En Revisión',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/en-revision',
            'icon' => 'IconFileSearch',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=>'requestInReview',
            'others_permissions' => "18@Validar Documentos, 18@Cancelar",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #20 En Evaluación
            'menu' => 'En Evaluación',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/en-evaluacion',
            'icon' => 'IconCheckupList',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=>'requestInEvaluation',
            'others_permissions' => "19@Evaluar, 19@Aprobar, 19@Rechazar, 19@Cancelar",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #20 Aprobadas
            'menu' => 'Aprobadas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/aprobadas',
            'icon' => 'IconFileCheck',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=>'requestApproved',
            'others_permissions' => "20@Pagar, 20@Cancelar",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #21 Pagadas
            'menu' => 'Pagadas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/pagadas',
            'icon' => 'IconFileDollar',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=>'requesPayed',
            'others_permissions' => "",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #22 Rechazadas
            'menu' => 'Rechazadas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/rechazadas',
            'icon' => 'IconFileDislike',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=>'requestRejected',
            // 'others_permissions' => "",
            'created_at' => now(),
        ]);
        $order += 1;
        DB::table('menus')->insert([ #23 Canceladas
            'menu' => 'Canceladas',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/canceladas',
            'icon' => 'IconFilesOff',
            'order' => $order,
            'show_counter'=> true,
            'counter_name'=>'requestRejected',
            // 'others_permissions' => "",
            'created_at' => now(),
        ]);
    }
}