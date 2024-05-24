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
        Schema::create('module_tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->default(false);
            $table->string('code')->nullable();
            $table->integer('rank')->nullable();
            $table->string('title');
            $table->string('type');
            $table->uuidMorphs('taskable');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->datetime('min_deadline')->nullable();
            $table->datetime('max_deadline')->nullable();
            $table->datetime('completed_at')->nullable();
            $table->uuid('completed_by')->nullable();
            $table->uuid('step_id')->index()->nullable();
            $table->json('extra')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litigation_tasks');
    }
};
