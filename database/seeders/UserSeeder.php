<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'username' => 'admin',
            'password' => Hash::make('desarrollo'),
            'role_id' => 1, //SuperAdmin
            'created_at' => now()
        ]);
        DB::table('users')->insert([
            'email' => 'escolares@gomezpalacio.gob.mx',
            'username' => 'escolares',
            'password' => Hash::make('escolares789'),
            'role_id' => 2, //Admin
            'created_at' => now()
        ]);
    }
}
