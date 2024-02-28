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
        Schema::create('answers_scores', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('option_1');
            $table->integer('score_1')->default(0);
            $table->string('option_1');
            $table->integer('score_1')->default(0);
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
        Schema::dropIfExists('answers_scores');
    }
};