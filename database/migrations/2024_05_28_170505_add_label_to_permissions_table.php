<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->uuid('permission_entity_id')->nullable();
            $table->foreign('permission_entity_id')->references('id')->on('permission_entities');
            $table->string('label')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_entity_id']);
            $table->dropColumn('permission_entity_id');
            $table->dropColumn('label');
        });
    }
};
