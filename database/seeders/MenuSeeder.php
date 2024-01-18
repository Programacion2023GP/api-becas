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
        $menuCatalogs = 7;
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
        $order = .1;
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
        DB::table('menus')->insert([ #3
            'menu' => 'Administrativo',
            'caption' => 'Control de usuarios y roles',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 2,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #4 Menus
            'menu' => 'Menus',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/menus',
            'icon' => 'IconCategory2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #5 Roles
            'menu' => 'Roles',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/roles',
            'icon' => 'IconPaperBag',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #6 Usuarios
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
        DB::table('menus')->insert([ #7
            'menu' => 'Catalogos',
            'caption' => 'Gestion de Catalogos',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 3,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #8 Escuelas
            'menu' => 'Escuelas',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/escuelas',
            'icon' => 'IconCarGarage',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #9 Servicios
            'menu' => 'Servicios',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/servicios',
            'icon' => 'IconBuildingSkyscraper',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #10 Niveles
            'menu' => 'Niveles',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/niveles',
            'icon' => 'IconNumber',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #11 Discapacidades
            'menu' => 'Discapacidades',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/discapacidades',
            'icon' => 'IconWheelchair',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #12 Perímetros
            'menu' => 'Perímetros',
            'type' => 'item',
            'belongs_to' => $menuCatalogs,
            'url' => '/admin/catalogos/perimetros',
            'icon' => 'IconRadar2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
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
            'menu' => 'Mis Solicitudes',
            'caption' => 'Solicitudes Realizadas',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 4,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #15 Marcas
            'menu' => 'Solicitudes',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/',
            'icon' => 'IconBadgeTm',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #16 Modelos
            'menu' => 'Modelos',
            'type' => 'item',
            'belongs_to' => $menuRequests,
            'url' => '/admin/solicitudes/mis-solicitudes',
            'icon' => 'IconBoxModel2',
            'order' => $order,
            'created_at' => now(),
        ]);
    }
}


// INSERT INTO menus VALUES
// (1,'Dashboard','','group',0,null,null,1,0,1,'2023-11-05 01:55:45',null,null),
// (2,'Buscador','','item',1,'/admin','IconSearch',1,0,1,'2023-11-05 01:55:45',null,null),
// (3,'Administrativo','Control de usuarios','group',0,null,null,2,0,1,'2023-11-05 01:55:45',null,null),
// (4,'Usuarios','','item',3,'/admin/usuarios','IconUsers',1,0,1,'2023-11-05 01:55:45',null,null),
// (5,'Roles','','item',3,'/admin/roles','IconPaperBag',2,0,1,'2023-11-05 01:55:45',null,null),
// (6,'Departamentos','','item',3,'/admin/departamentos','IconBuildingSkyscraper',3,0,1,'2023-11-05 01:55:45',null,null),
// (7,'Menus','','item',3,'/admin/menus','IconCategory2',4,0,1,'2023-11-05 01:55:45',null,null),
// (8,'catalogos','Catálogos del catalogos','group',0,null,null,3,0,1,'2023-11-05 01:55:45',null,null),
// (9,'Escuelas','','item',8,'/admin/catalogos/almacen','IconCarGarage',1,0,1,'2023-11-05 01:55:45',null,null),
// (10,'Servicios','','item',8,'/admin/catalogos/servicios','IconTool',2,0,1,'2023-11-05 01:55:45',null,null),
// (11,'Requisiones - PENDIENTE','','item',8,'/admin/catalogos/requisiciones','IconFileInvoice',3,0,1,'2023-11-05 01:55:45',null,null),
// (12,'CoVe','Control Vehicular','group',0,null,null,4,0,1,'2023-11-05 01:55:45',null,null),
// (13,'Marcas','','item',12,'/admin/cove/marcas','IconBadgeTm',1,0,1,'2023-11-05 01:55:45',null,null),
// (14,'Modelos','','item',12,'/admin/cove/modelos','IconBoxModel2',2,0,1,'2023-11-05 01:55:45',null,null),
// (15,'Estatus de Vehículos','','item',12,'/admin/cove/estatus-vehiculo','IconStatusChange',3,0,1,'2023-11-05 01:55:45',null,null),
// (16,'Vehículos','','item',12,'/admin/cove/vehiculos','IconCar',3,0,1,'2023-11-05 01:55:45',null,null);