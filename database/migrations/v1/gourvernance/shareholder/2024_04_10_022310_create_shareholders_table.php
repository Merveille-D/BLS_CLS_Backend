<?php

use App\Models\Shareholder\Shareholder;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
            $table->decimal('percentage', 5, 5)->nullable();

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shareholders');
    }
};
