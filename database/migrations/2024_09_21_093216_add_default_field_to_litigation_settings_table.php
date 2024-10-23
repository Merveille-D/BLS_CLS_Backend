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
        Schema::table('litigation_settings', function (Blueprint $table) {
            $table->boolean('default')->default(1);
            $table->uuid('created_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('litigation_settings', function (Blueprint $table) {
            $table->dropColumn(['default', 'created_by']);
        });
    }
};
