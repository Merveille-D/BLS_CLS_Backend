<?php

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
        Schema::create('ca_prodedures', function (Blueprint $table) {
            $table->id();
            $table->datetime('send_date');
            $table->string('document_name');
            $table->foreignId('ca_administrator_id');
            $table->foreignId('type_document_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_prodedures');
    }
};
