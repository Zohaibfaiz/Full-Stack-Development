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
    Schema::create('showtimes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('movie_id')->constrained()->cascadeOnDelete();
        $table->foreignId('screen_id')->constrained()->cascadeOnDelete();
        $table->dateTime('start_time');
        $table->dateTime('end_time');
        // We calculate end_time later based on movie duration
        $table->timestamps();

        // Ensure a movie isn't playing at the same screen at the exact same time
        $table->unique(['screen_id', 'start_time']); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
