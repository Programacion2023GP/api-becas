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
                'more_permissions' => '6@Asignar Permisos,15@Asignar Perímetro,17@Ver Puntaje,17@Continuar,17@Validar Documentos,17@Evaluar,17@Rechazar,17@Aprobar,17@Cancelar,17@Exportar Lista Contraloría,17@Exportar Lista Pública,17@Pagar,17@Corregir Documentos',
                'created_at' => now(),
            ], [
                'role' => 'Administrador',
                'description' => 'Rol dedicado para usuarios que gestionaran el sistema.',
                'read' => 'todas',
                'create' => 'todas',
                'update' => 'todas',
                'delete' => 'todas',
                'more_permissions' => '6@Asignar Permisos,15@Asignar Perímetro,17@Ver Puntaje,17@Continuar,17@Validar Documentos,17@Evaluar,17@Rechazar,17@Aprobar,17@Cancelar,17@Exportar Lista Contraloría,17@Exportar Lista Pública,17@Pagar,17@Corregir Documentos',
                'created_at' => now(),
            ], [
                'role' => 'Ciudadano',
                'description' => 'Rol dedicado para el ciudadano.',
                'read' => '1,3,16,18',
                'create' => '3,18',
                'update' => '',
                'delete' => '',
                'more_permissions' => '17@Continuar,17@Cancelar,17@Corregir Documentos',
                'created_at' => now(),
            ]
        ]);
    }
}