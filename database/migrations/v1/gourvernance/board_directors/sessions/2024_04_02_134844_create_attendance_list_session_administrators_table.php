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
        Schema::create('attendance_list_session_administrators', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('grade')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();

            $table->uuid('administrator_id');
            $table->foreign('administrator_id')->references('id')->on('ca_administrators')->onDelete('cascade');


            $table->uuid('session_id');
            $table->foreign('session_id')->references('id')->on('session_administrators')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_list_session_administrators');
    }
};
