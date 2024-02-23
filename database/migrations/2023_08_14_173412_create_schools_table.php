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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->foreignId('level_id')->constrained('levels', 'id');
            $table->string('school', 100);
            $table->integer('community_id')->default(0)->nullable()->comment("este dato viene de una API que por medio del C.P. nos arroja de estado a colonia");
            $table->string('street')->default('Sin calle')->nullable();
            $table->string('num_ext')->default("S/N")->nullable();
            $table->string('num_int')->nullable()->default("S/N");
            // $table->foreignId('city_id')->constrained('cities', 'id');
            // $table->foreignId('colony_id')->constrained('colonies', 'id');
            // $table->string('address');
            $table->string('phone')->default('S/N')->nullable();
            $table->string('director')->nullable();
            $table->boolean('loc_for')->default(1)->nullable()->comment("booleano para saber si la escuela es local=1 o foranea=0.");
            $table->enum('zone', ['U', 'R'])->nullable();
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
        Schema::dropIfExists('schools');
    }
};