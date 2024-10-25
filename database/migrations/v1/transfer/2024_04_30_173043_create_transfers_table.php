<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->boolean('status')->default(false);
            $table->string('title');
            $table->datetime('deadline')->nullable();
            $table->uuidMorphs('transferable');
            $table->text('description')->nullable();
            $table->uuid('sender_id')->nullable();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
