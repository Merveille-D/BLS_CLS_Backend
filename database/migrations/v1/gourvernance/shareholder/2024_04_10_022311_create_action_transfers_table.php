<?php

use App\Models\Shareholder\ActionTransfer;
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
        Schema::create('action_transfers', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->uuid('owner_id');
            $table->foreign('owner_id')->references('id')->on('shareholders')->onDelete('cascade');

            $table->uuid('buyer_id')->nullable();
            $table->foreign('buyer_id')->references('id')->on('shareholders')->onDelete('cascade');

            $table->uuid('tier_id')->nullable();
            $table->foreign('tier_id')->references('id')->on('tiers')->onDelete('cascade');

            $table->integer('count_actions');

            $table->date('transfer_date');

            $table->enum('type', ActionTransfer::TYPES );

            $table->enum('status', ActionTransfer::STATUS )->default('accepted');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_transfers');
    }
};
