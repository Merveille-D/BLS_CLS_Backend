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
        Schema::create('ag_step_type_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            $table->unsignedBigInteger('ag_step_id')->nullable();
            $table->foreign('ag_step_id')->references('id')->on('ag_steps')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ag_step_type_files');
    }
};
