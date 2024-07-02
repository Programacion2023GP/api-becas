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
        Schema::create('becas_payment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('beca_paid_id')->constrained('becas_paid', 'id');
            $table->foreignId('paid_by')->constrained('users', 'id');
            $table->foreignId('relationship_id')->constrained('relationships', 'id');
            $table->string('paid_to', 255);
            $table->decimal('amount_paid', 8, 2)->default(0.00);
            $table->string('img_evidence', 255);
            $table->string('paid_feedback', 255)->nullable();

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
        Schema::dropIfExists('becas_payment_details');
    }
};
