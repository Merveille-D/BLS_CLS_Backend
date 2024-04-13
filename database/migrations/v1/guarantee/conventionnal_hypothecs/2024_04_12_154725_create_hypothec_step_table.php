<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hypothec_step', function (Blueprint $table) {
            $table->id();
            $table->uuid('hypothec_id')->index();
            $table->foreign('hypothec_id')->references('id')->on('conv_hypothecs');
            $table->uuid('step_id')->index();
            $table->foreign('step_id')->references('id')->on('conv_hypothec_steps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hypothec_step');
    }
};
