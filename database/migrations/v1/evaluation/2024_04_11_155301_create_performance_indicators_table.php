<?php

use App\Models\Evaluation\PerformanceIndicator;
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
        Schema::create('performance_indicators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->enum('position', PerformanceIndicator::POSITIONS);
            $table->enum('type', PerformanceIndicator::TYPES);
            $table->string('note');
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_indicators');
    }
};
