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
        CREATE OR REPLACE VIEW becas_approved_view AS
        SELECT bv.*, ba.user_id 'user_approved_id', ua.username 'user_approved', ba.feedback, ba. created_at 'created_at_approved' FROM becas_approved ba
        INNER JOIN  becas_view bv ON ba.beca_id=bv.id
        INNER JOIN users ua ON ba.user_id=ua.id
        WHERE ba.active=1;
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
