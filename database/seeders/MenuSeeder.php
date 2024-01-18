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
        $menuAdmin = 3;
        $menuGarage = 13;
        $menuCove = 17;

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
        DB::table('menus')->insert([ #2 Buscador
            'menu' => 'Buscador',
            'caption' => '',
            'type' => 'item',
            'belongs_to' => $menuDashboard,
            'url' => '/admin',
            'icon' => 'IconSearch',
            'order' => $order,
            'created_at' => now(),
        ]);

        // ADMINISTRATIVO
        $order = 0;
        DB::table('menus')->insert([ #3
            'menu' => 'Administrativo',
            'caption' => 'Control de usuarios',
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
        DB::table('menus')->insert([ #6 Departamentos
            'menu' => 'Departamentos',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/departamentos',
            'icon' => 'IconBuildingSkyscraper',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #7 Usuarios
            'menu' => 'Usuarios',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/usuarios',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #8 Administradores
            'menu' => 'Administradores',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/administradores',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #9 Encargado de Almacen
            'menu' => 'Encargados de Almacen',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/encargados-de-almacen',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #10 Mecánicos
            'menu' => 'Mecánicos',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/mecanicos',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #11 Directores
            'menu' => 'Directores',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/directores',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #12 Conductores
            'menu' => 'Conductores',
            'type' => 'item',
            'belongs_to' => $menuAdmin,
            'url' => '/admin/conductores',
            'icon' => 'IconUsers',
            'order' => $order,
            'created_at' => now(),
        ]);

        // TALLER
        $order = 0;
        DB::table('menus')->insert([ #13
            'menu' => 'Taller',
            'caption' => 'Catálogos del Taller',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 3,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #14 Almacen (Stock)
            'menu' => 'Almacen (Stock)',
            'type' => 'item',
            'belongs_to' => $menuGarage,
            'url' => '/admin/taller/almacen',
            'icon' => 'IconCarGarage',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #15 Servicios
            'menu' => 'Servicios',
            'type' => 'item',
            'belongs_to' => $menuGarage,
            'url' => '/admin/taller/servicios',
            'icon' => 'IconTool',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #16 Requisiciones
            'menu' => 'Requisiciones - PENDIENTE',
            'type' => 'item',
            'belongs_to' => $menuGarage,
            'url' => '/admin/taller/requisiciones',
            'icon' => 'IconFileInvoice',
            'order' => $order,
            'created_at' => now(),
        ]);

        // CoVe
        $order = 0;
        DB::table('menus')->insert([ #17
            'menu' => 'CoVe',
            'caption' => 'Control Vehicular',
            'type' => 'group',
            'belongs_to' => 0,
            'order' => 4,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #18 Marcas
            'menu' => 'Marcas',
            'type' => 'item',
            'belongs_to' => $menuCove,
            'url' => '/admin/cove/marcas',
            'icon' => 'IconBadgeTm',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #19 Modelos
            'menu' => 'Modelos',
            'type' => 'item',
            'belongs_to' => $menuCove,
            'url' => '/admin/cove/modelos',
            'icon' => 'IconBoxModel2',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #20 Estatus de Vehículo
            'menu' => 'Estatus de Vehículos',
            'type' => 'item',
            'belongs_to' => $menuCove,
            'url' => '/admin/cove/estatus-vehiculo',
            'icon' => 'IconStatusChange',
            'order' => $order,
            'created_at' => now(),
        ]);
        $order = .1;
        DB::table('menus')->insert([ #21 Vehículos
            'menu' => 'Vehículos',
            'type' => 'item',
            'belongs_to' => $menuCove,
            'url' => '/admin/cove/vehiculos',
            'icon' => 'IconCar',
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
// (8,'Taller','Catálogos del Taller','group',0,null,null,3,0,1,'2023-11-05 01:55:45',null,null),
// (9,'Almacen (Stock)','','item',8,'/admin/taller/almacen','IconCarGarage',1,0,1,'2023-11-05 01:55:45',null,null),
// (10,'Servicios','','item',8,'/admin/taller/servicios','IconTool',2,0,1,'2023-11-05 01:55:45',null,null),
// (11,'Requisiones - PENDIENTE','','item',8,'/admin/taller/requisiciones','IconFileInvoice',3,0,1,'2023-11-05 01:55:45',null,null),
// (12,'CoVe','Control Vehicular','group',0,null,null,4,0,1,'2023-11-05 01:55:45',null,null),
// (13,'Marcas','','item',12,'/admin/cove/marcas','IconBadgeTm',1,0,1,'2023-11-05 01:55:45',null,null),
// (14,'Modelos','','item',12,'/admin/cove/modelos','IconBoxModel2',2,0,1,'2023-11-05 01:55:45',null,null),
// (15,'Estatus de Vehículos','','item',12,'/admin/cove/estatus-vehiculo','IconStatusChange',3,0,1,'2023-11-05 01:55:45',null,null),
// (16,'Vehículos','','item',12,'/admin/cove/vehiculos','IconCar',3,0,1,'2023-11-05 01:55:45',null,null);