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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->char('office', 255);
            $table->char('rfc', 13);
            $table->char('regime', 13)->nullable(true)->default('');
            $table->char('description', 255)->nullable(true)->default('');
            $table->boolean('active')->nullable(false)->default(1);
            $table->unsignedBigInteger('corporate_id');
            $table->foreign('corporate_id')->references('id')->on('corporates');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
