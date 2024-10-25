<?php

use App\Models\Gourvernance\Representant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('representants', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('grade')->nullable();
            $table->string('name')->nullable();
            $table->enum('type', Representant::MEETING_TYPE);

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('representants');
    }
};
