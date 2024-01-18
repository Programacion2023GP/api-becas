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
            'more_permissions' => 'todas',
            'created_at' => now(),
        ]);
        DB::table('roles')->insert([
            'role' => 'Administrador',
            'description' => 'Rol dedicado para usuarios que gestionaran el sistema.',
            'read' => 'todas',
            'create' => 'todas',
            'update' => 'todas',
            'delete' => 'todas',
            'more_permissions' => 'todas',
            'created_at' => now(),
        ]);
        DB::table('roles')->insert([
            'role' => 'Ciudadano',
            'description' => 'Rol dedicado para usuarios normales.',
            'created_at' => now(),
        ]);
    }
}
