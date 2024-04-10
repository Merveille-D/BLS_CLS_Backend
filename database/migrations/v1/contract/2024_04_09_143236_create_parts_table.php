<?php

use App\Models\Contract\Part;
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
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->date('residence')->nullable();
            $table->string('number_id')->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('number_rccm')->nullable();
            $table->string('number_ifu')->nullable();
            $table->string('id_card')->nullable();
            $table->string('capital')->nullable();
            $table->enum('type', Part::TYPES_PART)->nullable();
            $table->unsignedBigInteger('permanent_representative_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parts');
    }
};
