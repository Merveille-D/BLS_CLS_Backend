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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('state')->default('created');
            $table->string('sent_by')->default('system');
            $table->string('sent_to')->nullable();
            $table->text('data');
            $table->string('type')->nullable();
            $table->morphs('notifiable');
            $table->timestamp('read_at')->nullable();
            // $table->timestamp('trigger_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
