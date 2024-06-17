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
                'more_permissions' => 'todas',
                'page_index' => '/app',
                'created_at' => now(),
            ], [
                'role' => 'Administrador',
                'description' => 'Rol dedicado para usuarios que gestionaran el sistema.',
                'read' => '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24',
                'create' => '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24',
                'update' => '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24',
                'delete' => '1,2,3,4,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24',
                'more_permissions' => 'Asignar Permisos,Asignar Perímetro,Ver Puntaje,Continuar Solicitud,Validar Documentos,Evaluar
Solicitud,Cancelar Solicitud,Exportar Lista Contraloría,Exportar Lista Pública,Pagar Solicitud,Corregir Documentos',
                'page_index' => '/app',
                'created_at' => now(),
            ], [
                'role' => 'Ciudadano',
                'description' => 'Rol dedicado para el ciudadano.',
                'read' => '1,3,16,18',
                'create' => '3,18',
                'update' => '',
                'delete' => '',
                'more_permissions' => 'Continuar Solicitud,Cancelar Solicitud,Corregir Documentos',
                'page_index' => '/app/solicitudes/',
                'created_at' => now(),
            ]
        ]);
    }
}
