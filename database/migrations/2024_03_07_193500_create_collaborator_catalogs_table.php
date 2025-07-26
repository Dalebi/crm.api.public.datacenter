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
        Schema::create('collaborator_catalogs', function (Blueprint $table) {
            $table->id();
            $table->string('label')->nullable(false)->unique();
            $table->string('description')->nullable(true)->default('');
            $table->integer('order')->nullable(false)->default(1);
            $table->boolean('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborator_catalogs');
    }
};
