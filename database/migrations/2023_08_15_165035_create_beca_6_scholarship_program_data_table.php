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
            $table->foreignId('b6_beca_id')->constrained('becas', 'id');
            $table->boolean('b6_beca_transport')->nullable()->default(false);
            $table->boolean('b6_beca_benito_juarez')->nullable()->default(false);
            $table->boolean('b6_beca_jovenes')->nullable()->default(false);
            $table->boolean('b6_other')->nullable()->default(false); //$table->string('other')->nullable();
            $table->boolean('b6_finished')->nullable()->default(false);

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
