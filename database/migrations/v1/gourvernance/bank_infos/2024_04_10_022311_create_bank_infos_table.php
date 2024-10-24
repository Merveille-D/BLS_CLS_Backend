<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_infos', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('logo')->nullable();
            $table->string('denomination')->nullable();
            $table->string('siege_social')->nullable();
            $table->integer('total_shareholders')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_infos');
    }
};
