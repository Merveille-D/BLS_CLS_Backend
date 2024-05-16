<?php

use App\Models\Contract\ContractPart;
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
        Schema::create('contract_parts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('description');

            $table->enum('type', ContractPart::TYPE );

            $table->uuid('contract_id')->nullable();
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');

            $table->uuid('part_id')->nullable();
            $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_parts');
    }
};
