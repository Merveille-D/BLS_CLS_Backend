<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('litigationables', function (Blueprint $table) {
            $table->id();
            $table->uuid('litigation_id')->index();
            $table->foreign('litigation_id')->references('id')->on('litigations');
            $table->uuidMorphs('litigationable');
            $table->string('category')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('litigationables');
    }
};
