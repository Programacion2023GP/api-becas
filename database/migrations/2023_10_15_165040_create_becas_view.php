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
        SELECT b.*, usr.username, usr.email,
        td.tutor_relationship_id tutor_relationship_id, r.relationship tutor_relationship, td.tutor_curp tutor_curp, td.tutor_name tutor_name, td.tutor_paternal_last_name tutor_paternal_last_name, td.tutor_maternal_last_name tutor_maternal_last_name, td.tutor_phone tutor_phone,
        sd.curp, sd.name, sd.paternal_last_name, sd.maternal_last_name, sd.birthdate, sd.gender, sd.community_id, sd.street, sd.num_ext, sd.num_int, sd.disability_id, d.disability, d.description, 
        s.code, s.level_id, l.level, s.school, CONCAT(s.code,' - ', l.level,' - ', s.school) school_full, s.community_id as school_community_id, 
        s.street as school_street, s.num_ext as school_num_ext, s.num_int as school_num_int, s.phone, s.director, s.loc_for, s.zone,
        b3_food , b3_transport, b3_living_place, b3_services, b3_automobile, b3_finished,
        b4_house_is, b4_roof_material, b4_floor_material, b4_score, b4_finished,
        b5_beds, b5_washing_machines, b5_boilers, b5_tvs, b5_pcs, b5_phones, b5_music_player, b5_stoves, b5_refrigerators, b5_drinking_water, b5_electric_light, b5_sewer_system, b5_pavement, b5_automobile, b5_phone_line, b5_internet, b5_score, b5_finished,
        b6_beca_transport, b6_beca_benito_juarez, b6_beca_jovenes, b6_other, b6_finished,
        b7_img_tutor_ine, b7_approved_tutor_ine, b7_comments_tutor_ine, b7_img_tutor_power_letter, b7_approved_tutor_power_letter, b7_comments_tutor_power_letter, b7_img_second_ref, b7_approved_second_ref, b7_comments_second_ref, b7_img_proof_address, b7_approved_proof_address, b7_comments_proof_address, b7_img_curp, b7_approved_curp, b7_comments_curp, b7_img_birth_certificate, b7_approved_birth_certificate, b7_comments_birth_certificate, b7_img_academic_transcript, b7_approved_academic_transcript, b7_comments_academic_transcript, b7_finished,
        ua.username user_approved, ur.username user_rejected, uc.username user_canceled
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
        LEFT JOIN beca_7_documents_data b7 ON b.id=b7_beca_id
        LEFT JOIN users ua ON b.approved_by=ua.id
        LEFT JOIN users ur ON b.rejected_by=ur.id
        LEFT JOIN users uc ON b.canceled_by=uc.id
        WHERE b.active=1;
        ");
        // DB::statement("
        // CREATE OR REPLACE VIEW becas_view AS
        // SELECT b.*, usr.username, usr.email,
        // td.tutor_relationship_id tutor_relationship_id, r.relationship tutor_relationship, td.tutor_curp tutor_curp, td.tutor_name tutor_name, td.tutor_paternal_last_name tutor_paternal_last_name, td.tutor_maternal_last_name tutor_maternal_last_name, td.tutor_phone tutor_phone,
        // sd.curp, sd.name, sd.paternal_last_name, sd.maternal_last_name, sd.birthdate, sd.gender, sd.community_id, sd.street, sd.num_ext, sd.num_int, sd.disability_id, d.disability, d.description, 
        // s.code, s.level_id, l.level, s.school, CONCAT(s.code,' - ', l.level,' - ', s.school) school_full, s.community_id as school_community_id, 
        // s.street as school_street, s.num_ext as school_num_ext, s.num_int as school_num_int, s.phone, s.director, s.loc_for, s.zone,
        // b3_food , b3_transport, b3_living_place, b3_services, b3_automobile, b3_finished,
        // b4_house_is, b4_roof_material, b4_floor_material, b4_score, b4_finished,
        // b5_beds, b5_washing_machines, b5_boilers, b5_tvs, b5_pcs, b5_phones, b5_music_player, b5_stoves, b5_refrigerators, b5_drinking_water, b5_electric_light, b5_sewer_system, b5_pavement, b5_automobile, b5_phone_line, b5_internet, b5_score, b5_finished,
        // b6_beca_transport, b6_beca_benito_juarez, b6_beca_jovenes, b6_other, b6_finished,
        // b7_img_tutor_ine, b7_approved_tutor_ine, b7_comments_tutor_ine, b7_img_tutor_power_letter, b7_approved_tutor_power_letter, b7_comments_tutor_power_letter, b7_img_second_ref, b7_approved_second_ref, b7_comments_second_ref, b7_img_proof_address, b7_approved_proof_address, b7_comments_proof_address, b7_img_curp, b7_approved_curp, b7_comments_curp, b7_img_birth_certificate, b7_approved_birth_certificate, b7_comments_birth_certificate, b7_img_academic_transcript, b7_approved_academic_transcript, b7_comments_academic_transcript, b7_finished,
        // ur.username user_rejected
        // FROM becas as b 
        // INNER JOIN users usr ON b.user_id=usr.id
        // INNER JOIN beca_1_tutor_data td ON b.tutor_data_id=td.id
        // INNER JOIN relationships r ON td.tutor_relationship_id=r.id
        // INNER JOIN beca_1_student_data sd ON b.student_data_id=sd.id
        // INNER JOIN disabilities d ON sd.disability_id=d.id
        // INNER JOIN schools s ON b.school_id=s.id
        // INNER JOIN levels l ON s.level_id=l.id
        // -- LEFT JOIN beca_2_family_data b2 ON b.id=b2.beca_id
        // LEFT JOIN beca_3_economic_data b3 ON b.id=b3_beca_id
        // LEFT JOIN beca_4_house_data b4 ON b.id=b4_beca_id
        // LEFT JOIN beca_5_household_equipment_data b5 ON b.id=b5_beca_id
        // LEFT JOIN beca_6_scholarship_program b6 ON b.id=b6_beca_id
        // LEFT JOIN beca_7_documents_data b7 ON b.id=b7_beca_id
        // LEFT JOIN users ur ON b.rejected_by=ur.id
        // WHERE b.active=1;
        // ");
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
