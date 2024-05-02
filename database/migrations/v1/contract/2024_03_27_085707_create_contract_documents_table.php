<?php

use App\Models\Contract\Contract;
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
        Schema::create('contract_models', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_models');
    }
};
