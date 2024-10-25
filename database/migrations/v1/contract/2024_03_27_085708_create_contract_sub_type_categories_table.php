<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contract_sub_type_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('value');

            $table->uuid('contract_type_category_id')->nullable();
            $table->foreign('contract_type_category_id')->references('id')->on('contract_type_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contract_models');
    }
};
