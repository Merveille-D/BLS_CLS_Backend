<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendance_list_management_committees', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('director_id')->nullable();
            $table->foreign('director_id')->references('id')->on('directors')->onDelete('cascade');

            $table->uuid('representant_id')->nullable();
            $table->foreign('representant_id')->references('id')->on('representants')->onDelete('cascade');

            $table->uuid('session_id');
            $table->foreign('session_id')->references('id')->on('management_committees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_list_management_committees');
    }
};
