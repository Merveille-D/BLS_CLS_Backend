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
        Schema::create('recoveries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type');
            $table->string('status')->default('created');
            $table->string('reference')->unique()->nullable();
            $table->boolean('has_guarantee')->default(0);
            $table->uuid('guarantee_id')->nullable();
            $table->uuid('contract_id')->nullable();
            $table->boolean('is_entrusted')->default(0);
            $table->boolean('is_seized')->default(0);
            $table->boolean('is_archived')->default(0);
            $table->boolean('payement_status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recoveries');
    }
};
