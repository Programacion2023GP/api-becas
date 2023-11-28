<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('beca_questions')->insert([
            'secction' => 4,
            'question' => 'La casa donde vives es:',
            'type' => 'select',
            'created_at' => now(),
        ]);
        DB::table('beca_questions')->insert([
            'secction' => 4,
            'question' => 'Material del techo de la vivienda (si está hecho de más de un material, marca el que predomine)',
            'type' => 'select',
            'created_at' => now(),
        ]);
        DB::table('beca_questions')->insert([
            'secction' => 4,
            'question' => 'Material del piso de la vivienda (si está hecho de más de un material, marca el que predomine)',
            'type' => 'select',
            'created_at' => now(),
        ]);

        DB::table('beca_questions')->insert([
            'secction' => 5,
            'question' => 'Señala el número:',
            'type' => 'multio',
            'created_at' => now(),
        ]);
        DB::table('beca_questions')->insert([
            'secction' => 5,
            'question' => 'Material del techo de la vivienda (si está hecho de más de un material, marca el que predomine)',
            'type' => 'select',
            'created_at' => now(),
        ]);
        DB::table('beca_questions')->insert([
            'secction' => 6,
            'question' => 'Material del piso de la vivienda (si está hecho de más de un material, marca el que predomine)',
            'type' => 'select',
            'created_at' => now(),
        ]);
    }
}
