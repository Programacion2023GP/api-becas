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
        // Schema::create('beca_options', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('beca_question_id');
        //     $table->string('option');
        //     $table->integer('score')->default(0);
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
        Schema::dropIfExists('beca_options');
    }
};
