<?php

use App\Models\Gourvernance\Mandate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mandates', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->date('appointment_date')->nullable();
            $table->date('renewal_date')->nullable();
            $table->date('expiry_date')->nullable();

            $table->enum('status', Mandate::STATUS)->default('active');

            $table->uuidMorphs('mandatable');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mandates');
    }
};
