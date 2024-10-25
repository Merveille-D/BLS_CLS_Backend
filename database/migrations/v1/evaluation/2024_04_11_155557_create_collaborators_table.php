<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collaborators', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('lastname');
            $table->string('firstname');

            $table->uuid('user_id')->nullable();

            $table->uuid('position_id')->nullable();
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
