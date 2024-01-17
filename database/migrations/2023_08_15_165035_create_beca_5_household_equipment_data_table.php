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
        Schema::create('beca_5_household_equipment_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b5_beca_id')->constrained('becas', 'id');
            $table->integer('b5_beds')->nullable();
            $table->integer('b5_washing_machines')->nullable();
            $table->integer('b5_boilers')->nullable();
            $table->integer('b5_tvs')->nullable();
            $table->integer('b5_pcs')->nullable();
            $table->integer('b5_phones')->nullable();
            $table->integer('b5_music_player')->nullable();
            $table->integer('b5_stoves')->nullable();
            $table->integer('b5_refrigerators')->nullable();

            $table->boolean('b5_drinking_water')->nullable();
            $table->boolean('b5_electric_light')->nullable();
            $table->boolean('b5_sewer_system')->nullable();
            $table->boolean('b5_pavement')->nullable();
            $table->boolean('b5_automobile')->nullable();
            $table->boolean('b5_phone_line')->nullable();
            $table->boolean('b5_internet')->nullable();
            $table->integer('b5_score')->nullable();
            $table->boolean('b5_finished')->nullable()->default(false);

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
        Schema::dropIfExists('beca_5_household_equipment_data');
    }
};
