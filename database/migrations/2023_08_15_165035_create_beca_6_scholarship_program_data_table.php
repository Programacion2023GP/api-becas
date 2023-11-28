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
        Schema::create('beca_6_scholarship_program', function (Blueprint $table) {
            $table->id();
            $table->integer("beca_id");
            $table->boolean('beca_transport')->default(false);
            $table->boolean('beca_benito_juarez')->default(false);
            $table->string('other')->nullable();

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
        Schema::dropIfExists('beca_6_scholarship_program');
    }
};
