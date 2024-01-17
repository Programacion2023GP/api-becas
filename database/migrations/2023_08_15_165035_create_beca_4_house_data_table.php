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
        Schema::create('beca_4_house_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b4_beca_id')->constrained('becas', 'id');
            $table->string('b4_house_is')->nullable();
            $table->string('b4_roof_material')->nullable();
            $table->string('b4_floor_material')->nullable();
            $table->integer('b4_score')->nullable();
            $table->boolean('b4_finished')->nullable()->default(false);

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
        Schema::dropIfExists('beca_4_house_data');
    }
};