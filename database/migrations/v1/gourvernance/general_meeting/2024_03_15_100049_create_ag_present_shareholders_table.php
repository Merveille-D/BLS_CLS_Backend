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
        Schema::create('ag_present_shareholders', function (Blueprint $table) {
            $table->id();
            $table->string('shareholder_firstname');
            $table->string('shareholder_lastname');
            $table->unsignedBigInteger('shareholder_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ag_present_shareholders');
    }
};
