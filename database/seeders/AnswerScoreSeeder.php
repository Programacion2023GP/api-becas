<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class AnswerScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers_scores')->insert([
            'family_1' => '1:0-3=3, 2:4-7=2, 3:8-100=1',
            'economic_1' => '1:10001-50000=1, 2:7001-10000=3, 3:0-7000=5',
            'economic_2' => '1:10001-50000=1, 2:7001-10000=3, 3:0-7000=5',
            'house_1' => '1:1, 2:3, 3:5, 4:2',
            'house_2' => '1:5, 2:2', '1:5, 2:3, 3:1',
            'house_3' => '1:0-1=5, 2:2-5=3, 3:6-100=1',
            'household_equipment_1' => '1:0-0=5, 2:1-1=3, 3:2-10=1',
            'household_equipment_2' => '1:0-0=5, 2:1-1=2, 3:2-10=1',
            'household_equipment_3' => '1:0-0=5, 2:1-3=3, 3:4-10=1',
            'household_equipment_4' => '1:0-0=5, 2:1-2=3, 3:3-10=1',
            'household_equipment_5' => '1:0-0=5, 2:1-3=3, 3:4-10=1',
            'household_equipment_6' => '1:0-0=5, 2:1-1=3, 3:2-10=1',
            'household_equipment_7' => '1:0-0=5, 2:1-1=3, 3:2-10=1',
            'household_equipment_8' => '1:0-0=5, 2:1-1=3, 3:2-10=1',
            'household_equipment_9' => '1:0-0=5, 2:1-1=3, 3:2-10=1',
            'service_1' => '5',
            'service_2' => '5',
            'service_3' => '3',
            'service_4' => '2',
            'service_5' => '1',
            'service_6' => '1',
            'service_7' => '1',
            'scholarship_1' => '5',
            'scholarship_2' => '5',
            'scholarship_3' => '5',
            'scholarship_4' => '5',
            'total_score' => '0',
            'medium_score' => '0',
            'medium_low_score' => '25',
            'low_score' => '50',
            'active' => '1',
            'created_at' => '2024-04-11 15:42:25',
            'updated_at' => '2024-04-11 15:42:25',
            // 'deleted_at'=>NULL,
        ]);
    }
}
