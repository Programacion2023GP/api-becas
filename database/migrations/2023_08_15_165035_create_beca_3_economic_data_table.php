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
            $table->integer("beca_id");
            $table->decimal('food', 11, 2)->comment("despensa");
            $table->decimal('transport', 11, 2);
            $table->decimal('living_place', 11, 2)->comment("vivienda");
            $table->decimal('services', 11, 2)->comment("agua y luz");
            $table->decimal('automobile', 11, 2);
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
