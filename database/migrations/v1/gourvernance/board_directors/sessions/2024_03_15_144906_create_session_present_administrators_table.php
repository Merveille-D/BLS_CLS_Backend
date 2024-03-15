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

            $table->string('administrator_lastname');
            $table->string('administrator_firstname');

            $table->unsignedBigInteger('session_administrator_id')->nullable();
            $table->foreign('session_administrator_id')->references('id')->on('session_administrators')->onDelete('cascade');

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
