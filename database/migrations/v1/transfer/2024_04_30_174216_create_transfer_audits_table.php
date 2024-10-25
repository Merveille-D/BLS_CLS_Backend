<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('audit_id');
            $table->uuid('transfer_id')->nullable();
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_documents');
    }
};
