<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_user', function (Blueprint $table) {
            $table->id();
            $table->uuid('transfer_id');
            $table->uuid('user_id');
            $table->foreign('transfer_id')->references('id')->on('transfers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_user');
    }
};
