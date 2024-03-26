<?php

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\TaskGeneralMeeting;
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
        Schema::create('task_general_meetings', function (Blueprint $table) {
            $table->id();

            $table->string('libelle');
            $table->datetime('deadline')->nullable();

            $table->enum('type', TaskGeneralMeeting::MEETING_TASK_TYPE );
            $table->enum('status', GeneralMeeting::GENERAL_MEETING_STATUS );

            $table->string('responsible')->nullable();
            $table->string('supervisor')->nullable();

            $table->unsignedBigInteger('general_meeting_id')->nullable();
            $table->foreign('general_meeting_id')->references('id')->on('general_meetings')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_general_meetings');
    }
};
