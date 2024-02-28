<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'role' => 'SuperAdmin',
            'description' => 'Rol dedicado para la completa configuraciond del sistema desde el area de desarrollo.',
            'read' => 'todas',
            'create' => 'todas',
            'update' => 'todas',
            'delete' => 'todas',
            'more_permissions' => '6@Asignar Roles,15@Validar Documentos,15@Evaluar,15@Cancelar,16@Cancelar',
            'created_at' => now(),
        ]);
        DB::table('roles')->insert([
            'role' => 'Administrador',
            'description' => 'Rol dedicado para usuarios que gestionaran el sistema.',
            'read' => 'todas',
            'create' => 'todas',
            'update' => 'todas',
            'delete' => 'todas',
            'more_permissions' => '6@Asignar Roles,15@Validar Documentos,15@Evaluar,15@Cancelar,16@Cancelar',
            'created_at' => now(),
        ]);
        DB::table('roles')->insert([
            'role' => 'Ciudadano',
            'description' => 'Rol dedicado para el ciudadano.',
            'read' => '1,3,14,16',
            'create' => '3,16',
            'update' => '',
            'delete' => '',
            'more_permissions' => '16@Cancelar',
            'created_at' => now(),
        ]);
    }
}
