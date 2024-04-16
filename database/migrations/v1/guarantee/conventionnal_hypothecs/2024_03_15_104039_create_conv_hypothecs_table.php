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
        Schema::create('conv_hypothecs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('state');
            $table->string('reference')->unique();
            $table->enum('step', array('formalization', 'realization'));
            $table->uuid('contract_id')->nullable();
            //file
            $table->string('contract_file')->nullable();
            //end file
            $table->date('registering_date')->nullable();
            $table->date('registration_date')->nullable();
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_subscribed')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->date('date_signification')->nullable();
            $table->date('visa_date')->nullable();
            $table->string('type_actor')->nullable();
            $table->boolean('is_significated')->default(0);
            $table->date('date_sell')->nullable();
            $table->date('advertisement_date')->nullable();
            $table->date('summation_date')->nullable();
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
        Schema::dropIfExists('conv_hypothecs');
    }
};
