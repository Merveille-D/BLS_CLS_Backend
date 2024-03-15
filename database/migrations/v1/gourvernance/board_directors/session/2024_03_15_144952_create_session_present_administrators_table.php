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
        Schema::create('session_present_administrators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_administrator_id');
            $table->string('administrator_lastname');
            $table->string('administrator_firstname');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_present_administrators');
    }
};
