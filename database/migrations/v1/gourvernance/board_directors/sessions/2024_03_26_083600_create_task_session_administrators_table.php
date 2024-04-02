<?php

use App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator;
use App\Models\Gourvernance\BoardDirectors\Sessions\TaskSessionAdministrator;
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
        Schema::create('task_session_administrators', function (Blueprint $table) {
            $table->id();

            $table->string('libelle');
            $table->datetime('deadline')->nullable();

            $table->enum('type', TaskSessionAdministrator::SESSION_TASK_TYPE );
            $table->enum('status', SessionAdministrator::SESSION_MEETING_STATUS );


            $table->string('responsible')->nullable();
            $table->string('supervisor')->nullable();

            $table->unsignedBigInteger('session_administrator_id')->nullable();
            $table->foreign('session_administrator_id')->references('id')->on('session_administrators')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_session_administrators');
    }
};
