<?php

use App\Models\Bank\Bank;
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
        Schema::create('capitals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->integer('amount');
            $table->integer('par_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capitals');
    }
};
