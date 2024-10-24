<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_type_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('value');

            $table->uuid('contract_category_id')->nullable();
            $table->foreign('contract_category_id')->references('id')->on('contract_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_models');
    }
};
