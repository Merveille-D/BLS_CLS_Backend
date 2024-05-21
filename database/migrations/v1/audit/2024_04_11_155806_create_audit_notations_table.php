<?php

use App\Models\Audit\AuditNotation;
use App\Models\Audit\AuditPerformanceIndicator;
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
        Schema::create('audit_notations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('note')->nullable();
            $table->string('status')->default('evaluated');
            $table->string('observation')->nullable();

            $table->uuid('audit_period_id');
            $table->foreign('audit_period_id')->references('id')->on('audit_periods')->onDelete('cascade');

            $table->uuid('module_id');
            $table->enum('module', AuditPerformanceIndicator::MODULES);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_notations');
    }
};
