<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AnswerScore;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            MenuSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            AnswerScoreSeeder::class,
            // PerimeterSeeder::class,
            LevelSeeder::class,
            SchoolSeeder::class,
            DisabilitySeeder::class,
            RelationshipSeeder::class
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
