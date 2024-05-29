<?php

use App\Models\Shareholder\Shareholder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shareholders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->enum('type', Shareholder::TYPES);
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->enum('corporate_type', Shareholder::CORPORATE_TYPES)->nullable();
            $table->unsignedBigInteger('actions_number');
            $table->unsignedBigInteger('actions_encumbered');
            $table->unsignedBigInteger('actions_no_encumbered');
            $table->integer('percentage')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shareholders');
    }
};
