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
        Schema::create('litigations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('state')->default('created');
            $table->string('reference');
            $table->double('estimated_amount')->nullable();
            $table->double('added_amount')->nullable();
            $table->double('remaining_amount')->nullable();
            $table->boolean('is_achirved')->default(0);
            $table->uuid('jurisdiction_id')->index()->nullable();
            $table->foreign('jurisdiction_id')->references('id')->on('litigation_resources');
            $table->uuid('nature_id')->index()->nullable();
            $table->foreign('nature_id')->references('id')->on('litigation_resources');
            $table->uuid('lawyer_id')->nullable();
            $table->foreign('lawyer_id')->references('id')->on('litigation_lawyers');
            $table->uuid('party_id')->nullable();
            $table->foreign('party_id')->references('id')->on('litigation_parties');
            $table->uuid('user_id')->nullable();
            // $table->foreign('user_id')->references('id')->on('users'); //TODO: uncomment after auth implementation
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('litigations');
    }
};
