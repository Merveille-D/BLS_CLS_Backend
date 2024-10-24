<?php

use App\Enums\AdminFunction;
use App\Enums\AdminType;
use App\Enums\Quality;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ca_administrators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('birthplace')->nullable();
            $table->integer('age')->nullable();
            $table->string('nationality')->nullable();
            $table->string('address')->nullable();
            $table->enum('function', AdminFunction::ADMIN_FUNCTIONS)->nullable();
            $table->enum('quality', Quality::QUALITIES)->nullable();
            $table->double('shares')->nullable();
            $table->enum('type', AdminType::TYPES)->nullable();
            $table->double('share_percentage')->nullable();
            $table->uuid('permanent_representative_id')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ca_administrators');
    }
};
