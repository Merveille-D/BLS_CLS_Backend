;<?php

use App\Models\Alert\Alert;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('state')->default('created');
            $table->datetime('deadline')->nullable();
            $table->enum('priority', Alert::STATUS);
            $table->string('type');
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->timestamp('trigger_at');
            $table->uuidMorphs('alertable');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alerts');
    }
};
