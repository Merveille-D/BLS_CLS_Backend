<?php

use App\Models\Incident\Incident;
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
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date_received');

            $table->enum('type', Incident::TYPES );

            $table->unsignedBigInteger('author_incident_id');
            $table->foreign('author_incident_id')->references('id')->on('author_incidents')->onDelete('cascade');

            $table->unsignedBigInteger('user_id')->nullable();

            $table->boolean('client');
            $table->boolean('status')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incidents');
    }
};
