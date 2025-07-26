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
        Schema::create('quote_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('label', 255);
            $table->string('description', 255)->nullable(true)->default('');
            $table->integer('order')->nullable(false)->default(1);
            $table->boolean('required')->nullable(false)->default(1);
            $table->boolean('active')->nullable(false)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_catalogs');
    }
};
