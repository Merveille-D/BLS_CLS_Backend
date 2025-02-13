<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('directors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->date('birthdate')->nullable();
            $table->string('position')->nullable();
            $table->string('birthplace')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('directors');
    }
};
