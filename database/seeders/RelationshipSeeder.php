<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class RelationshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('relationships')->insert([
            'relationship' => 'MADRE',
            'created_at' => now(),
        ]);
        DB::table('relationships')->insert([
            'relationship' => 'PADRE',
            'created_at' => now(),
        ]);
        DB::table('relationships')->insert([
            'relationship' => 'ABUELA',
            'created_at' => now(),
        ]);
        DB::table('relationships')->insert([
            'relationship' => 'ABUELO',
            'created_at' => now(),
        ]);
        DB::table('relationships')->insert([
            'relationship' => 'TIO',
            'created_at' => now(),
        ]);
        DB::table('relationships')->insert([
            'relationship' => 'TIA',
            'created_at' => now(),
        ]);
    }
}
