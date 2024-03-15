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
        Schema::create('ag_archive_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');

            $table->unsignedBigInteger('general_meeting_id')->nullable();
            $table->foreign('general_meeting_id')->references('id')->on('general_meetings')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ag_archive_files');
    }
};
