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
        // Schema::create('beca_questions', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('secction');
        //     $table->string('question');
        //     $table->enum('type', ["text", "select", "multiple"]);
        //     $table->boolean('active')->default(true);
        //     $table->timestamps();
        //     $table->dateTime('deleted_at')->nullable();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beca_questions');
    }
};
