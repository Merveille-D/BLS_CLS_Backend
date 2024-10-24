<?php

use App\Models\Contract\Part;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('residence')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('number_rccm')->nullable();
            $table->string('number_ifu')->nullable();
            $table->string('id_card');
            $table->string('capital')->nullable();
            $table->enum('type', Part::TYPES_PART)->nullable();
            $table->uuid('permanent_representative_id')->nullable();

            $table->uuid('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
