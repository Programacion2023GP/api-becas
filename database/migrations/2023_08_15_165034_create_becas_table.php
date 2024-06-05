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
        Schema::create('becas', function (Blueprint $table) {
            $table->id();
            $table->integer('folio');
            $table->foreignId('user_id')->constrained('users', 'id');
            $table->foreignId('tutor_data_id')->constrained('beca_1_tutor_data', 'id');

            $table->foreignId('student_data_id')->constrained('beca_1_student_data', 'id');
            $table->foreignId('school_id')->constrained('schools', 'id')->nullable();
            $table->integer('grade')->nullable();
            $table->decimal('average', 8, 2)->nullable();

            $table->decimal('extra_income', 11, 2)->nullable();
            $table->decimal('monthly_income', 11, 2)->nullable();

            $table->decimal('total_expenses', 11, 2)->nullable();
            $table->boolean('under_protest')->nullable()->comment("aceptando bajo protesta");

            $table->text('comments')->nullable();

            $table->enum('socioeconomic_study', ['SIN EVALUAR', 'BAJO', 'MEDIO-BAJO', 'MEDIO'])->default('SIN EVALUAR')->nullable();
            $table->integer('score_total')->default(0)->nullable();
            $table->integer('current_page')->default(4)->nullable();
            $table->enum("status", ["ALTA", "TERMINADA", "EN REVISIÓN", "EN EVALUACIÓN", "RECHAZADA", "APROBADA", "PAGADA", "ENTREGADA", "CANCELADA"])->default("ALTA");
            $table->dateTime('end_date')->nullable();

            $table->integer('rejected_by')->nullable();
            $table->dateTime('rejected_feedback')->nullable();
            $table->dateTime('rejected_at')->nullable();

            $table->string('second_ref')->nullable()->comment("esto indica si habra una segunda persona que pueda recoger la beca");
            $table->boolean('correction_permission')->default(0)->comment("para cuando los admin solicitan cambiar documentos, Des/habilitar el btn");
            $table->boolean('correction_completed')->default(0)->comment("para cuando finalizan estos cambios en documentos, notificar al admin");


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
        Schema::dropIfExists('becas');
    }
};
