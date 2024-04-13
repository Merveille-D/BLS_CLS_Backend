<?php

use App\Models\Gourvernance\ExecutiveManagement\ManagementCommittee\TaskManagementCommittee;
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
        Schema::create('task_management_committees', function (Blueprint $table) {
            $table->id();

            $table->string('libelle');
            $table->datetime('deadline')->nullable();

            $table->enum('type', TaskManagementCommittee::SESSION_TASK_TYPE );
            $table->boolean('status')->default(false);

            $table->string('responsible')->nullable();
            $table->string('supervisor')->nullable();

            $table->unsignedBigInteger('management_committee_id')->nullable();
            $table->foreign('management_committee_id')->references('id')->on('management_committees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_management_committees');
    }
};
