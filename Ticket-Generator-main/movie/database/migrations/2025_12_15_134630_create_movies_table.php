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
    Schema::create('movies', function (Blueprint $table) {
        $table->id();
        $table->integer('tmdb_id')->nullable()->unique(); // For API lookups
        $table->string('title');
        $table->text('overview');
        $table->string('poster_path');
        $table->date('release_date');
        $table->integer('duration_minutes');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
