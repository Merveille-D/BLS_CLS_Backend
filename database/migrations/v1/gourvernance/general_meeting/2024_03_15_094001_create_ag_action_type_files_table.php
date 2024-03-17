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
        Schema::create('ag_action_type_files', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            
            $table->unsignedBigInteger('ag_action_id')->nullable();
            $table->foreign('ag_action_id')->references('id')->on('ag_actions')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ag_action_type_files');
    }
};
