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
        Schema::create('answers_scores', function (Blueprint $table) {
            $table->id();
            $table->string('family_1')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('economic_1')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('economic_2')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('house_1')->comment("estructura: 1:pts, 2:pts, 3:pts, 4:pst");
            $table->string('house_2')->comment("estructura: 1:pts, 2:pts");
            $table->string('house_3')->comment("estructura: 1:pts, 2:pts, 3:pts");
            $table->string('household_equipment_1')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_2')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_3')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_4')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_5')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_6')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_7')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_8')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->string('household_equipment_9')->comment("estructura: 1:min-max=pts, 2:min-max=pts, 3:min-max=pts");
            $table->integer('service_1')->comment("estructura: pts");
            $table->integer('service_2')->comment("estructura: pts");
            $table->integer('service_3')->comment("estructura: pts");
            $table->integer('service_4')->comment("estructura: pts");
            $table->integer('service_5')->comment("estructura: pts");
            $table->integer('service_6')->comment("estructura: pts");
            $table->integer('service_7')->comment("estructura: pts");
            $table->integer('scholarship_1')->comment("estructura: pts");
            $table->integer('scholarship_2')->comment("estructura: pts");
            $table->integer('scholarship_3')->comment("estructura: pts");
            $table->integer('scholarship_4')->comment("estructura: pts");
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
        Schema::dropIfExists('answers_scores');
    }
};