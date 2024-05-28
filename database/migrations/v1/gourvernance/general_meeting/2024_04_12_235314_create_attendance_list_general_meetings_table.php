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
        Schema::create('attendance_list_general_meetings', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('grade')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();

            $table->uuid('shareholder_id');
            // $table->foreign('shareholder_id')->references('id')->on('shareholders')->onDelete('cascade');

            $table->uuid('representant_id')->nullable();
            $table->foreign('representant_id')->references('id')->on('representants')->onDelete('cascade');

            $table->uuid('general_meeting_id');
            $table->foreign('general_meeting_id')->references('id')->on('general_meetings')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_list_general_meetings');
    }
};
