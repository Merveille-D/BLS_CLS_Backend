<?php

use App\Models\Incident\TaskIncident;
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
        Schema::create('task_action_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->text('title');
            $table->datetime('deadline');
            $table->string('code');

            $table->uuid('created_by');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('action_transfer_id');
            $table->foreign('action_transfer_id')->references('id')->on('action_transfers')->onDelete('cascade');

            $table->boolean('status')->default(false);

            $table->boolean('asked_agrement')->nullable();

            $table->date('date')->nullable();
            $table->uuid('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_action_transfers');
    }
};
