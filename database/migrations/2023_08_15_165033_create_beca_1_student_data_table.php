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
        Schema::create('beca_1_student_data', function (Blueprint $table) {
            $table->id();
            $table->string('curp');
            $table->string('name');
            $table->string('paternal_last_name');
            $table->string('maternal_last_name');
            $table->date('birthdate');
            $table->enum('gender', ['MASCULINO', 'FEMENINO']);
            $table->integer('community_id')->comment('este dato viene de una api externa brindando de estado hasta colonia');
            $table->string('street');
            $table->string('num_ext');
            $table->string('num_int')->default("S/N");
            $table->foreignId('disability_id')->constrained('disabilities', 'id');
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
        Schema::dropIfExists('beca_1_student_data');
    }
};
