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
        Schema::create('recovery_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('type');
            $table->string('name');
            $table->date('deadline')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recovery_steps');
    }
};
