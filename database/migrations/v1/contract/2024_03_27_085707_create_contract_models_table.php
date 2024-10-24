<?php

use App\Models\Contract\ContractModel;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_models', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('parent_id')->nullable();
            $table->string('name');

            $table->enum('type', ContractModel::TYPE)->nullable();

            $table->string('file_path')->nullable();

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_models');
    }
};
