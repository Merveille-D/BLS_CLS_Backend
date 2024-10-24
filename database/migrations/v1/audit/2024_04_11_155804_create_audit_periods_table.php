<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_periods', function (Blueprint $table) {

            $table->uuid('id')->primary();
            $table->string('title');
            $table->datetime('deadline');
            $table->boolean('status')->default(false);

            $table->uuid('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_notation_performances');
    }
};
