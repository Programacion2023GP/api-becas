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
        Schema::create('beca_7_documents_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b7_beca_id')->constrained('becas', 'id');

            $table->string('b7_img_tutor_ine', 255)->nullable();
            $table->boolean('b7_approved_tutor_ine')->nullable();
            $table->string('b7_comments_tutor_ine', 250)->nullable()->default("Archivo cargado correctamente.");

            $table->string('b7_img_tutor_power_letter', 255)->nullable();
            $table->boolean('b7_approved_tutor_power_letter')->nullable();
            $table->string('b7_comments_tutor_power_letter', 250)->nullable()->default("Archivo cargado correctamente.")->comment("Aplica solo en caso de que el tutor no sea su padre o madre");

            $table->string('b7_img_second_ref', 255)->nullable();
            $table->boolean('b7_approved_second_ref')->nullable();
            $table->string('b7_comments_second_ref', 250)->nullable()->default("Archivo cargado correctamente.")->comment("Aplica solo en caso de que quieran un represnetante (2da opcion) para recoger la beca");


            $table->string('b7_img_proof_address', 255)->nullable();
            $table->boolean('b7_approved_proof_address')->nullable();
            $table->string('b7_comments_proof_address', 250)->nullable()->default("Archivo cargado correctamente.");

            $table->string('b7_img_curp', 255)->nullable();
            $table->boolean('b7_approved_curp')->nullable();
            $table->string('b7_comments_curp', 250)->nullable()->default("Archivo cargado correctamente.");

            $table->string('b7_img_birth_certificate', 255)->nullable();
            $table->boolean('b7_approved_birth_certificate')->nullable();
            $table->string('b7_comments_birth_certificate', 250)->nullable()->default("Archivo cargado correctamente.");

            $table->string('b7_img_academic_transcript', 255)->nullable()->comment("Constancia de estudios con calificación");
            $table->boolean('b7_approved_academic_transcript')->nullable();
            $table->string('b7_comments_academic_transcript', 250)->nullable()->default("Archivo cargado correctamente.");

            $table->boolean('b7_finished')->nullable()->default(false);

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
        Schema::dropIfExists('beca_7_documents_data');
    }
};
