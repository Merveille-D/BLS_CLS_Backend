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

            $table->uuid('owner_id')->nullable();
            $table->foreign('owner_id')->references('id')->on('shareholders')->onDelete('cascade');

            $table->uuid('buyer_id')->nullable();
            $table->foreign('buyer_id')->references('id')->on('shareholders')->onDelete('cascade');

            $table->integer('count_actions');

            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();

            $table->date('transfer_date');
            $table->date('ask_date')->nullable();

            $table->enum('status', ActionTransfer::STATUS )->default(ActionTransfer::STATUS[1]);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capitals');
    }
};
