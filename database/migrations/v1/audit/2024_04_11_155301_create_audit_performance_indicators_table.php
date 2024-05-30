<?php

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
        Schema::create('audit_performance_indicators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->enum('module', AuditPerformanceIndicator::MODULES);
            $table->enum('type', AuditPerformanceIndicator::TYPES);
            $table->string('note');
            $table->text('description');
            
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_performance_indicators');
    }
};
