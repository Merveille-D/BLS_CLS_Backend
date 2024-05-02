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
        Schema::create('hypothec_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->default(false);
            $table->string('code')->nullable();
            $table->integer('rank')->nullable();
            $table->string('name');
            $table->string('type');
            $table->uuid('hypothec_id')->index();
            $table->foreign('hypothec_id')->references('id')->on('conv_hypothecs');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->date('min_deadline')->nullable();
            $table->date('max_deadline')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hypothec_tasks');
    }
};
