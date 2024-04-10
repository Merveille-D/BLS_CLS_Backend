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
        Schema::create('litigation_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('state')->default('created');
            $table->string('file_name');
            $table->string('file_path');
            $table->uuidMorphs('documentable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litigation_documents');
    }
};
