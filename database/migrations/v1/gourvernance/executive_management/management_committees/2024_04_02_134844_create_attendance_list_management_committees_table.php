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
        Schema::create('attendance_list_management_committees', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('grade')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();

            $table->uuid('director_id');
            // $table->foreign('director_id')->references('id')->on('directors')->onDelete('cascade');


            $table->uuid('session_id');
            // $table->foreign('session_id')->references('id')->on('management_committees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_list_management_committees');
    }
};
