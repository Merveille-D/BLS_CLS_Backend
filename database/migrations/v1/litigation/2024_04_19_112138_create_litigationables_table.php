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
        Schema::create('litigationables', function (Blueprint $table) {
            $table->id();
            $table->uuid('litigation_id');
            $table->foreign('litigation_id')->references('id')->on('litigations');
            $table->uuidMorphs('litigationable');
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litigationables');
    }
};
