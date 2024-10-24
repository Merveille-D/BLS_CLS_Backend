<?php

use App\Models\Gourvernance\GourvernanceDocument;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gourvernance_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->nullable();
            $table->string('file');
            $table->enum('status', GourvernanceDocument::FILE_STATUS);
            $table->uuidMorphs('uploadable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gourvernance_documents');
    }
};
