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
        Schema::create('recovery_task', function (Blueprint $table) {
            $table->id();
            $table->boolean('status')->default(false);
            $table->string('type')->default('step');
            $table->uuid('recovery_id')->index();
            $table->foreign('recovery_id')->references('id')->on('recoveries');
            $table->uuid('step_id')->index()->nullable();
            $table->string('name')->nullable();
            $table->foreign('step_id')->references('id')->on('recovery_steps');
            $table->date('deadline')->nullable();

            $table->string('responsible')->nullable();
            $table->string('supervisor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recovery_tasks');
    }
};
