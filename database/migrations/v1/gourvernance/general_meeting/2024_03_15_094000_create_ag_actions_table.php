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
        Schema::create('ag_actions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('status')->default(false);
            $table->boolean('is_file')->default(false)->nullable();
            $table->datetime('closing_date')->nullable();
            $table->enum('step_ag_day', ['checklist', 'procedures'])->nullable();

            $table->unsignedBigInteger('general_meeting_id');
            $table->foreign('general_meeting_id')->references('id')->on('general_meetings')->onDelete('cascade');

            $table->unsignedBigInteger('ag_type_id');
            $table->foreign('ag_type_id')->references('id')->on('ag_types')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ag_actions');
    }
};
