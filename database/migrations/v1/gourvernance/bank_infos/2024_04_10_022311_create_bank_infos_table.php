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
        Schema::create('bank_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('logo');
            $table->string('denomination');
            $table->string('siege_social');
            $table->integer('total_shareholders')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_infos');
    }
};
