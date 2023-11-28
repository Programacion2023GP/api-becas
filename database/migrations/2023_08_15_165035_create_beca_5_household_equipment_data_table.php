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
            $table->integer("beca_id");
            $table->integer('beds');
            $table->integer('washing_machines');
            $table->integer('boilers');
            $table->integer('tvs');
            $table->integer('pcs');
            $table->integer('music_player');
            $table->integer('stoves');
            $table->integer('refrigerators');

            $table->boolean('drinking_water');
            $table->boolean('electric_light');
            $table->boolean('sewer_system');
            $table->boolean('pavement');
            $table->boolean('automobile');
            $table->boolean('phone_line');
            $table->boolean('internet');
            $table->integer('score');

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
