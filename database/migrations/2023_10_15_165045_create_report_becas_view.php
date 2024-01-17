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
        CREATE OR REPLACE VIEW report_becas_view AS
        SELECT b.id, b.folio 'Folio', r.relationship 'Parentesco del Tutor', td.tutor_curp 'CURP Tutor',  td.tutor_name 'Nombre Tutor', td.tutor_paternal_last_name 'Apellido Paterno Tutor', td.tutor_maternal_last_name 'Apellido Materno Tutor', td.tutor_phone 'Teléfono Tutor',td.tutor_img_ine 'INE Tutor', td.tutor_img_power_letter 'Carta Poder Tutor'
        
        
        
        usr.email,
        ,  , , , ,
        sd.curp, sd.name, sd.paternal_last_name, sd.maternal_last_name, sd.birthdate, sd.gender, sd.community_id, sd.street, sd.num_ext, sd.num_int, sd.disability_id, d.disability, d.description, 
        s.code, s.level_id, l.level, s.school, s.community_id as school_community_id, 
        s.street as school_street, s.num_ext as school_num_ext, s.num_int as school_num_int, s.phone, s.director, s.loc_for, s.zone,
        b3_food , b3_transport, b3_living_place, b3_services, b3_automobile, b3_finished,
        b4_house_is, b4_roof_material, b4_floor_material, b4_score, b4_finished,
        b5_beds, b5_washing_machines, b5_boilers, b5_tvs, b5_pcs, b5_phones, b5_music_player, b5_stoves, b5_refrigerators, b5_drinking_water, b5_electric_light, b5_sewer_system, b5_pavement, b5_automobile, b5_phone_line, b5_internet, b5_score, b5_finished,
        b6_beca_transport, b6_beca_benito_juarez, b6_beca_jovenes, b6_other, b6_finished
        FROM becas as b 
        INNER JOIN users usr ON b.user_id=usr.id
        INNER JOIN beca_1_tutor_data td ON b.tutor_data_id=td.id
        INNER JOIN relationships r ON td.tutor_relationship_id=r.id
        INNER JOIN beca_1_student_data sd ON b.student_data_id=sd.id
        INNER JOIN disabilities d ON sd.disability_id=d.id
        INNER JOIN schools s ON b.school_id=s.id
        INNER JOIN levels l ON s.level_id=l.id
        -- LEFT JOIN beca_2_family_data b2 ON b.id=b2.beca_id
        LEFT JOIN beca_3_economic_data b3 ON b.id=b3_beca_id
        LEFT JOIN beca_4_house_data b4 ON b.id=b4_beca_id
        LEFT JOIN beca_5_household_equipment_data b5 ON b.id=b5_beca_id
        LEFT JOIN beca_6_scholarship_program b6 ON b.id=b6_beca_id
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
        DB::statement('DROP VIEW IF EXISTS report_becas_view');
    }
};