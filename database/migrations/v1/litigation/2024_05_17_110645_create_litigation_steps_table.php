<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('litigation_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code');
            $table->string('title');
            $table->integer('rank');
            $table->integer('parent_id')->nullable();
            $table->string('type');
            $table->integer('min_delay')->nullable();
            $table->integer('max_delay')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('litigation_steps');
    }
};
