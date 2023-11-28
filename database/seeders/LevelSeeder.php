<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            'level' => 'PRIMARIA',
            'created_at' => now(),
        ]);
        DB::table('levels')->insert([
            'level' => 'SECUNDARIA',
            'created_at' => now(),
        ]);
    }
}
