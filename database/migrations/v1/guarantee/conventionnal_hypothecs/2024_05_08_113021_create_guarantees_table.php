<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guarantees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('status')->default('created');
            $table->string('reference')->unique();
            $table->string('security')->default('personal');
            $table->string('type');
            $table->string('phase');
            $table->uuid('contract_id')->nullable();
            $table->string('contract_type')->nullable();
            $table->boolean('is_paid')->default(false);
            $table->boolean('is_executed')->default(false);
            $table->boolean('has_recovery')->default(0);
            $table->uuid('created_by')->nullable();
            $table->json('extra')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guarantees');
    }
};
