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
        Schema::table('corporate_catalog_data', function (Blueprint $table) {
            $table->foreign('corporate_id')->references('id')->on('corporates');
            $table->foreign('corporate_catalog_id')->references('id')->on('corporate_catalogs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('corporate_catalog_data', function (Blueprint $table) {
            //
        });
    }
};
