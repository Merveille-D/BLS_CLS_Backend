<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guarantee_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('state')->nullable();
            $table->string('type')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('file_mime')->nullable();
            $table->uuidMorphs('documentable');
            // $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guarantee_documents');
    }
};
