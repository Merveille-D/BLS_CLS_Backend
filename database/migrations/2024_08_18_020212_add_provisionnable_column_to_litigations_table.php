<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('litigations', function (Blueprint $table) {
            $table->boolean('has_provisions')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('litigations', function (Blueprint $table) {
            $table->dropColumn('has_provisions');
        });
    }
};
