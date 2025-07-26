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
        Schema::table('collaborator_catalog_data', function (Blueprint $table) {
            $table->foreign('collaborator_id')->references('id')->on('collaborators');
            $table->foreign('collaborator_catalog_id')->references('id')->on('collaborator_catalogs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('collaborator_catalog_data', function (Blueprint $table) {
            //
        });
    }
};
