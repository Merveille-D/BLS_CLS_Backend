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
        Schema::create('general_meetings', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('reference');
            $table->datetime('meeting_date');
            $table->enum('type', \App\Models\Gourvernance\GeneralMeeting\GeneralMeeting::GENERAL_MEETING_TYPES );

            $table->unsignedBigInteger('ag_step_id')->default(1);
            $table->foreign('ag_step_id')->references('id')->on('ag_steps')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_meetings');
    }
};
