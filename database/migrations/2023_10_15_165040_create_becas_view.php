<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW becas_view AS
        SELECT b.*, usr.email,
        td.tutor_curp tutor_curp, td.tutor_name tutor_name, td.tutor_paternal_last_name tutor_paternal_last_name, td.tutor_maternal_last_name tutor_maternal_last_name, td.tutor_img_ine, td.tutor_img_power_letter,
        sd.curp, sd.name, sd.paternal_last_name, sd.maternal_last_name, sd.birthdate, sd.gender, sd.community_id as student_community_id, 
        sd.street as student_street, sd.num_ext as student_num_ext, sd.num_int as student_num_int, sd.disability_id, d.disability, 
        d.description, s.code, s.level_id, l.level, s.school, s.community_id as school_community_id, 
        s.street as school_street, s.num_ext as school_num_ext, s.num_int as school_num_int, s.phone, s.director, s.loc_for, s.zone
        FROM becas as b 
        INNER JOIN users usr ON b.user_id=usr.id
        INNER JOIN beca_1_tutor_data td ON b.tutor_data_id=td.id
        INNER JOIN beca_1_student_data sd ON b.student_data_id=sd.id
        INNER JOIN disabilities d ON sd.disability_id=d.id
        INNER JOIN schools s ON b.school_id=s.id
        INNER JOIN levels l ON s.level_id=l.id
        WHERE b.active=1;
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS becas_view');
    }
};
