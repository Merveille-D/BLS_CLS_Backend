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
        Schema::create('legal_watches', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
            $table->string('reference');
            $table->string('type');
            $table->text('summary');
            $table->text('innovation');
            $table->boolean('is_archived')->default(false);
            $table->date('event_date')->nullable();
            $table->date('effective_date')->nullable();
            $table->uuid('nature_id')->index()->nullable();
            $table->foreign('nature_id')->references('id')->on('litigation_settings');
            $table->uuid('jurisdiction_id')->index()->nullable();
            $table->foreign('jurisdiction_id')->references('id')->on('litigation_settings');

            $table->string('recipient_type')->nullable();
            $table->string('mail_object')->nullable();
            $table->string('mail_content')->nullable();
            $table->json('mail_addresses')->nullable();
            $table->boolean('is_sent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_watches');
    }
};
