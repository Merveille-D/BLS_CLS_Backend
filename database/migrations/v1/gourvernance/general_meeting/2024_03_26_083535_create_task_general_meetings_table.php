<?php

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
use App\Models\Gourvernance\GeneralMeeting\TaskGeneralMeeting;
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
            $table->uuid('id')->primary();

            $table->string('libelle')->nullable();
            $table->string('code')->nullable();
            
            $table->datetime('deadline')->nullable();

            $table->enum('type', TaskGeneralMeeting::MEETING_TASK_TYPE );
            $table->boolean('status')->default(false);

            $table->string('responsible')->nullable();
            $table->string('supervisor')->nullable();

            $table->uuid('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('general_meeting_id')->nullable();
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
