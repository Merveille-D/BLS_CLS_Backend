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
            $table->string('reference')->nullable();
            $table->double('estimated_amount')->nullable();
            $table->json('added_amount')->nullable();
            $table->double('remaining_amount')->nullable();
            $table->boolean('is_archived')->default(0);
            $table->uuid('jurisdiction_id')->index();
            $table->foreign('jurisdiction_id')->references('id')->on('litigation_settings');
            $table->string('jurisdiction_location');
            $table->uuid('nature_id')->index();
            $table->foreign('nature_id')->references('id')->on('litigation_settings');
            $table->uuid('lawyer_id')->nullable();
            // $table->foreign('lawyer_id')->references('id')->on('litigation_lawyers');
            // $table->uuid('party_id')->nullable();
            // $table->foreign('party_id')->references('id')->on('litigation_parties');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users'); //TODO: uncomment after auth implementation
            $table->json('extra')->nullable();
            $table->softDeletes();
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
