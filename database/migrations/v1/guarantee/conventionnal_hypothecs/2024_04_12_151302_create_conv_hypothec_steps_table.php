<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conv_hypothec_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('name');
            $table->integer('rank');
            $table->integer('parent_id')->nullable();
            $table->string('type');
            $table->integer('min_delay')->nullable();
            $table->integer('max_delay')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conv_hypothec_steps');
    }
};
