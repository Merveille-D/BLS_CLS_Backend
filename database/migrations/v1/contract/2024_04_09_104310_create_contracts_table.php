<?php

use App\Models\Contract\Contract;
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
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->enum('category', Contract::CATEGORIES);
            $table->string('type_category');
            $table->string('contract_file');
            $table->date('date_signature')->nullable();
            $table->date('date_effective')->nullable();
            $table->date('date_expiration')->nullable();
            $table->date('date_renewal')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
