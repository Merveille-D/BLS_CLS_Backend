<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('executive_committees', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuidMorphs('committable');

            $table->uuid('committee_id')->nullable();
            $table->foreign('committee_id')->references('id')->on('committees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandates');
    }
};
