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
            $table->foreignId('beca_id')->constrained('becas', 'id');
            $table->string('relationship')->nullable()->comment("parentesco con el alumno");
            $table->integer('age')->nullable();
            $table->string('occupation')->nullable();
            $table->string('monthly_income')->nullable();

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