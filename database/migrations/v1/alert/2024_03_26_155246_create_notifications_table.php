<?php

use App\Models\Alert\Alert;
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
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sent_by')->default('system');
            $table->string('sent_to')->nullable();
            $table->enum('priority', Alert::STATUS );
            $table->string('type');
            $table->text('data');
            $table->uuidMorphs('notifiable');
            $table->timestamp('read_at')->nullable();
            // $table->timestamp('trigger_at')->nullable();

            $table->uuid('alert_id')->nullable();
            $table->foreign('alert_id')->references('id')->on('alerts')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
