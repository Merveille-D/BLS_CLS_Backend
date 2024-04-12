<?php

use App\Models\Incident\TaskIncident;
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
        Schema::create('task_incidents', function (Blueprint $table) {
            $table->id();

            $table->text('title');

            $table->enum('info_channel', TaskIncident::CHANNELS)->nullable();
            $table->date('date')->nullable();

            $table->boolean('raised_hand')->nullable();

            $table->unsignedBigInteger('incident_id')->nullable();
            $table->foreign('incident_id')->references('id')->on('incidents')->onDelete('cascade');

            $table->boolean('status')->default(false);

            $table->string('code');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_incidents');
    }
};
