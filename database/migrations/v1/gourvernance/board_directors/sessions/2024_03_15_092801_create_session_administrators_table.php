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
        Schema::create('session_administrators', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('reference');
            $table->datetime('session_date');
            $table->enum('type', \App\Models\Gourvernance\BoardDirectors\Sessions\SessionAdministrator::SESSION_MEETING_TYPES );

            $table->unsignedBigInteger('session_step_id')->default(1);
            $table->foreign('session_step_id')->references('id')->on('session_steps')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_administrators');
    }
};
