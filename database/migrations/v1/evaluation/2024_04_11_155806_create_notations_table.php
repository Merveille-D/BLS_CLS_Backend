<?php

use App\Models\Evaluation\Notation;
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
        Schema::create('notations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('note')->nullable();
            $table->string('status')->default('evaluated');
            $table->string('observation')->nullable();

            $table->uuid('evaluation_period_id');
            $table->foreign('evaluation_period_id')->references('id')->on('evaluation_periods')->onDelete('cascade');

            $table->uuid('collaborator_id');
            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notations');
    }
};
