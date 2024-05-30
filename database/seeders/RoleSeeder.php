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
            [
                'role' => 'SuperAdmin',
                'description' => 'Rol dedicado para la completa configuraciond del sistema desde el area de desarrollo.',
                'read' => 'todas',
                'create' => 'todas',
                'update' => 'todas',
                'delete' => 'todas',
                'more_permissions' => '6@Asignar Permisos,14@Asignar Perímetro,16@Continuar,16@Validar Documentos,16@Evaluar,16@Rechazar,16@Aprobar,16@Cancelar,16@Exportar Lista Contraloría,16@Exportar Lista Pública,16@Pagar,16@Corregir Documentos',
                'created_at' => now(),
            ], [
                'role' => 'Administrador',
                'description' => 'Rol dedicado para usuarios que gestionaran el sistema.',
                'read' => 'todas',
                'create' => 'todas',
                'update' => 'todas',
                'delete' => 'todas',
                'more_permissions' => '6@Asignar Permisos,14@Asignar Perímetro,16@Continuar,16@Validar Documentos,16@Evaluar,16@Rechazar,16@Aprobar,16@Cancelar,16@Exportar Lista Contraloría,16@Exportar Lista Pública,16@Pagar,16@Corregir Documentos',
                'created_at' => now(),
            ], [
                'role' => 'Ciudadano',
                'description' => 'Rol dedicado para el ciudadano.',
                'read' => '1,3,15,17',
                'create' => '3,17',
                'update' => '',
                'delete' => '',
                'more_permissions' => '16@Continuar,16@Cancelar,16@Corregir Documentos',
                'created_at' => now(),
            ]
        ]);
    }
}
