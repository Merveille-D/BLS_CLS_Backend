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
            $table->uuid('id')->primary();
            $table->string('title');
            $table->date('date_received');

            $table->enum('type', Incident::TYPES );

            $table->uuid('author_incident_id');
            $table->foreign('author_incident_id')->references('id')->on('author_incidents')->onDelete('cascade');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->uuid('user_id')->nullable();
            $table->string('reference');
            $table->string('incident_reference')->nullable();

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
