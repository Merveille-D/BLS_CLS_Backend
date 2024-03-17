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
        Schema::create('ca_administrators', function (Blueprint $table) {
            $table->id();
            // Personne Physique
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birthday');
            $table->string('birthplace');
            $table->integer('age');
            $table->string('nationality');
            $table->string('address');
            $table->string('grade');
            $table->string('quality');

            $table->string('is_uemoa');

            // Personne morale
            $table->string('denomination')->nullable();
            $table->string('siege')->nullable();
            $table->string('representant')->nullable();

            $table->string('avis_cb')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ca_administrators');
    }
};
