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
        Schema::table('legal_watches', function (Blueprint $table) {
            $table->string('jurisdiction_location')->nullable();
            $table->string('case_number')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_watches', function (Blueprint $table) {
            $table->dropColumn('jurisdiction_location');
            $table->dropColumn('case_number');
            $table->dropSoftDeletes();
        });
    }
};
