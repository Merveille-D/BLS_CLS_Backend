<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guarantee_steps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('guarantee_type');
            $table->string('code');
            $table->string('title');
            $table->integer('rank')->nullable();
            // $table->integer('parent_id')->nullable();
            $table->string('step_type')->nullable();
            $table->integer('min_delay')->nullable();
            $table->integer('max_delay')->nullable();
            $table->string('formalization_type')->nullable();
            $table->uuid('parent_id')->nullable();
            $table->string('parent_response')->nullable();
            $table->json('extra')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guarantee_steps');
    }
};
