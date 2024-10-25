<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recovery_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status')->default('created');
            $table->string('type')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_path');
            $table->string('file_size')->nullable();
            $table->string('file_mime')->nullable();
            $table->uuidMorphs('documentable');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recovery_documents');
    }
};
