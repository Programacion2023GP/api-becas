<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beca_1_tutor_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_relationship_id')->constrained('relationships', 'id');
            $table->string('tutor_curp');
            $table->string('tutor_name');
            $table->string('tutor_paternal_last_name');
            $table->string('tutor_maternal_last_name');
            // $table->boolean('single_mother')->nullable();
            $table->string('tutor_img_ine')->nullable();
            $table->string('tutor_img_power_letter')->nullable();
            $table->string('tutor_phone')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beca_1_tutor_data');
    }
};
