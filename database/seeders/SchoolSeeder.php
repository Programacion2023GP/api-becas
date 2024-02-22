<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schools')->insert([
            'code' => '10DPR0697Z',
            'level_id' => 1,
            'school' => 'PDTE ADOLFO LOPEZ MATEOS',
            'community_id' => 1,
            'street' => 'CUAUHTEMOC Y ESCOBEDO COL SANTA ROSA',
            'num_ext' => '187',
            'num_int' => 'S/N',
            // 'city_id' => 1,
            // 'colony_id' => 1,
            'phone' => '8717143002',
            'director' => 'MARIA GUADALUPE VAZQUEZ RAMOS',
            'zone' => 'U',
            'created_at' => now(),
        ]);
        DB::table('schools')->insert([
            'code' => '10EPR0099C',
            'level_id' => 2,
            'school' => 'ESCUELA PRIMARIA 20 DE NOVIEMBRE',
            'community_id' => 1,
            'street' => 'SANTIAGO LAVIN 260 PTE',
            'num_ext' => '187',
            'num_int' => 'S/N',
            // 'city_id' => 1,
            // 'colony_id' => 2,
            'phone' => '8717141411',
            'director' => 'MA. GUILLERMINA CISNEROS VALDEZ',
            'zone' => 'U',
            'created_at' => now(),
        ]);
    }
}