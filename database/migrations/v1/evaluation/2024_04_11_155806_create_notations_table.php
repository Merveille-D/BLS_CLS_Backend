<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notations', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('note')->nullable();
            $table->string('status')->default('Evalué');
            $table->string('observation')->nullable();

            $table->uuid('parent_id')->nullable();
            $table->string('reference');
            $table->string('evaluation_reference');

            $table->uuid('collaborator_id');
            $table->foreign('collaborator_id')->references('id')->on('collaborators')->onDelete('cascade');

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notations');
    }
};
