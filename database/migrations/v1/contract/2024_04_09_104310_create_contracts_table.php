<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');

            $table->uuid('contract_category_id')->nullable();
            $table->foreign('contract_category_id')->references('id')->on('contract_categories')->onDelete('cascade');

            $table->uuid('contract_type_category_id')->nullable();
            $table->foreign('contract_type_category_id')->references('id')->on('contract_type_categories')->onDelete('cascade');

            $table->uuid('contract_sub_type_category_id')->nullable();
            $table->foreign('contract_sub_type_category_id')->references('id')->on('contract_sub_type_categories')->onDelete('cascade');

            $table->date('date_signature')->nullable();
            $table->date('date_effective')->nullable();
            $table->date('date_expiration')->nullable();
            $table->date('date_renewal')->nullable();
            $table->string('status')->default('Initié');

            $table->string('contract_reference');
            $table->string('reference');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
