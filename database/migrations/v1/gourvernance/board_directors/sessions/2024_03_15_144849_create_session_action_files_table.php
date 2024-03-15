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
        Schema::create('session_action_files', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('name');
            $table->string('file');

            $table->unsignedBigInteger('session_action_id')->nullable();
            $table->foreign('session_action_id')->references('id')->on('session_actions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_action_files');
    }
};
