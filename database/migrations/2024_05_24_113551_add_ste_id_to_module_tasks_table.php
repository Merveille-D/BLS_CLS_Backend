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
        Schema::table('module_tasks', function (Blueprint $table) {
            $table->uuid('step_id')->index()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('module_tasks', function (Blueprint $table) {
            $table->dropColumn('step_id');
        });
    }
};
