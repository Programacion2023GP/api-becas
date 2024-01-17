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
        Schema::create('beca_3_economic_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b3_beca_id')->constrained('becas', 'id');
            $table->decimal('b3_food', 11, 2)->nullable()->comment("despensa");
            $table->decimal('b3_transport', 11, 2)->nullable();
            $table->decimal('b3_living_place', 11, 2)->nullable()->comment("vivienda");
            $table->decimal('b3_services', 11, 2)->nullable()->comment("agua y luz");
            $table->decimal('b3_automobile', 11, 2)->nullable();
            $table->boolean('b3_finished')->nullable()->default(false);

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
        Schema::dropIfExists('beca_3_economic_data');
    }
};
