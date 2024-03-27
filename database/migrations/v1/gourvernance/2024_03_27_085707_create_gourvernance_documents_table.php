<?php

use App\Models\Gourvernance\GourvernanceDocument;
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
        Schema::create('gourvernance_documents', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('file');
            $table->enum('status', GourvernanceDocument::FILE_STATUS );
            $table->morphs('uploadable');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gourvernance_documents');
    }
};
