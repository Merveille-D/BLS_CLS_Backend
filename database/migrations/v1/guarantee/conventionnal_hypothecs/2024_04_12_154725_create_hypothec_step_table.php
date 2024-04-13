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
            $table->uuid('hypothec_id');
            $table->unsignedBigInteger('step_id');
            // $table->foreign('conv_hypothec_id')->references('id')->on('conv_hypothecs');
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
