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
        Schema::create('conventionnal_hypothecs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_verified')->default(0);
            $table->date('date_subscribed')->nullable();
            $table->boolean('is_subscribed')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->date('date_signification')->nullable();
            $table->string('type_actor')->nullable();
            $table->boolean('is_significated')->default(0);
            $table->date('date_sell')->nullable();
            $table->date('date_deposit_specification')->nullable();
            $table->boolean('is_publied')->default(0);
            $table->double('sell_price_estate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conventionnal_hypothecs');
    }
};
