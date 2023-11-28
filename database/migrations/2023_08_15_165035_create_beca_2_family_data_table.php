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
        Schema::create('beca_2_family_data', function (Blueprint $table) {
            $table->id();
            $table->integer("beca_id");
            $table->string('relationship')->comment("parentesco con el alumno");
            $table->integer('age');
            $table->string('occupation');
            $table->string('monthly_income');
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
        Schema::dropIfExists('beca_2_family_data');
    }
};
