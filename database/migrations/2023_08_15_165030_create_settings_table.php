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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            #Seccion generales
            $table->text('description')->nullable();
            #Seccion catalogos
            $table->string('filtered_state_ids')->nullable();
            #Seccion becas
            $table->integer('monthly_income_min')->default(0);
            $table->integer('total_expenses_min')->default(0);
            // $table->dateTime('')

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
        Schema::dropIfExists('settings');
    }
};