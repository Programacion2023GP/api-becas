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
        // Schema::create('beca_4_house_data', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer("beca_id");
        //     $table->integer('question_1')->default(0);
        //     $table->integer('question_2')->default(0);
        //     $table->integer('question_3')->default(0);
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
        Schema::dropIfExists('beca_4_house_data');
    }
};
