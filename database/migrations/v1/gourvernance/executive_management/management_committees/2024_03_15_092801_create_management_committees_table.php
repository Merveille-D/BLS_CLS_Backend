<?php

use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\ManagementCommittee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_committees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('libelle');
            $table->string('session_reference');
            $table->datetime('session_date');

            $table->string('pv_file')->nullable();
            $table->string('pv_file_date')->nullable();

            $table->string('convocation_file')->nullable();
            $table->string('convocation_file_date')->nullable();

            $table->string('agenda_file')->nullable();
            $table->string('agenda_file_date')->nullable();

            $table->string('attendance_list_file')->nullable();
            $table->string('attendance_list_file_date')->nullable();

            $table->string('reference');
            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->enum('status', ManagementCommittee::SESSION_MEETING_STATUS)->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_committees');
    }
};
