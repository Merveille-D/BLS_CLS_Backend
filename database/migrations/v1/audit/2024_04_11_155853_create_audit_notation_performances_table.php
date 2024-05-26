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
        Schema::create('audit_notation_performances', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('audit_notation_id');
            $table->foreign('audit_notation_id')->references('id')->on('audit_notations')->onDelete('cascade');

            $table->uuid('audit_performance_indicator_id');
            $table->foreign('performance_indicator_id')->references('id')->on('audit_performance_indicators')->onDelete('cascade');

            $table->string('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_notation_performances');
    }
};
