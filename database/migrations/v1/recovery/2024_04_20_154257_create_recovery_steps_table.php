<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recovery_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('type');
            $table->string('title');
            $table->date('deadline')->nullable();
            $table->integer('rank')->nullable();
            $table->integer('parent_id')->nullable();
            $table->unsignedInteger('min_delay')->nullable();
            $table->unsignedInteger('max_delay')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recovery_steps');
    }
};
