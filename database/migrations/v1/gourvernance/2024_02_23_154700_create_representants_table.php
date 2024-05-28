<?php

use App\Models\Gourvernance\Mandate;
use App\Models\Gourvernance\Representant;
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
        Schema::create('representants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('grade')->nullable();
            $table->string('name')->nullable();
            $table->enum('type', Representant::MEETING_TYPE);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representants');
    }
};
