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
        DB::table('beca_options')->insert([
            'beca_question_id' => 1,
            'option' => 'Propia',
            'score' => 4,
            'created_at' => now(),
        ]);
        DB::table('beca_options')->insert([
            'beca_question_id' => 1,
            'option' => 'Alquilada',
            'score' => 3,
            'created_at' => now(),
        ]);
        DB::table('beca_options')->insert([
            'beca_question_id' => 1,
            'option' => 'Prestada',
            'score' => 2,
            'created_at' => now(),
        ]);
        DB::table('beca_options')->insert([
            'beca_question_id' => 1,
            'option' => 'Otra',
            'score' => 1,
            'created_at' => now(),
        ]);

        DB::table('beca_options')->insert([
            'beca_question_id' => 2,
            'option' => 'Lámina (de cartón, de asbesto, madera)',
            'score' => 1,
            'created_at' => now(),
        ]);
        DB::table('beca_option s')->insert([
            'beca_question_id' => 2,
            'option' => 'Fimre de concreto',
            'score' => 2,
            'created_at' => now(),
        ]);

        DB::table('beca_options')->insert([
            'beca_question_id' => 3,
            'option' => 'Tierra',
            'score' => 1,
            'created_at' => now(),
        ]);
        DB::table('beca_options')->insert([
            'beca_question_id' => 3,
            'option' => 'Cemento',
            'score' => 2,
            'created_at' => now(),
        ]);
        DB::table('beca_options')->insert([
            'beca_question_id' => 3,
            'option' => 'Mosaico, loseta, madera laminada',
            'score' => 3,
            'created_at' => now(),
        ]);

        DB::table('beca_options')->insert([
            'beca_question_id' => 4,
            'option' => 'Camas',
            'score' => 1,
            'created_at' => now(),
        ]);
    }
}
