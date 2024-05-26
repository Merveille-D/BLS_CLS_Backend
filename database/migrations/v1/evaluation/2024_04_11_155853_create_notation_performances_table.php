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
        Schema::create('notation_performances', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('notation_id');
            $table->foreign('notation_id')->references('id')->on('notations')->onDelete('cascade');

            $table->uuid('performance_indicator_id');
            $table->foreign('performance_indicator_id')->references('id')->on('performance_indicators')->onDelete('cascade');

            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notation_performances');
    }
};
