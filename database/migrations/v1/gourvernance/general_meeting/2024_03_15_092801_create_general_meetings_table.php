<?php

use App\Models\Gourvernance\GeneralMeeting\GeneralMeeting;
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

            $table->string('pv_file')->nullable();
            $table->string('pv_file_date')->nullable();

            $table->string('convocation_file')->nullable();
            $table->string('convocation_file_date')->nullable();

            $table->string('agenda_file')->nullable();
            $table->string('agenda_file_date')->nullable();

            $table->string('attendance_list_file')->nullable();
            $table->string('attendance_list_file_date')->nullable();

            $table->enum('status', GeneralMeeting::GENERAL_MEETING_STATUS )->default('pending');

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
