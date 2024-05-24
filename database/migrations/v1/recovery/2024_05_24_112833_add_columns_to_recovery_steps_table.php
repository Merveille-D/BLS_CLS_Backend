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
        Schema::table('recovery_steps', function (Blueprint $table) {
            $table->unsignedInteger('min_delay')->nullable();
            $table->unsignedInteger('max_delay')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recovery_steps', function (Blueprint $table) {
            $table->dropColumn('min_delay');
            $table->dropColumn('max_delay');
        });
    }
};
