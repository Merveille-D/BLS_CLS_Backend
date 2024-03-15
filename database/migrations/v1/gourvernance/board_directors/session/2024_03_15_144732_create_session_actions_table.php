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
        Schema::create('session_actions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('status');
            $table->boolean('is_file')->default(false);
            $table->datetime('closing_date')->nullable();
            $table->foreignId('session_administrator_id')->nullable();
            $table->foreignId('session_type_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_actions');
    }
};
