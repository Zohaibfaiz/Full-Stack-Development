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
    Schema::create('screens', function (Blueprint $table) {
        $table->id();
        $table->foreignId('cinema_id')->constrained()->cascadeOnDelete();
        $table->string('name'); // e.g., "Screen 1", "IMAX Hall"
        $table->integer('capacity')->default(0);
        $table->timestamps();

        $table->unique(['name', 'cinema_id']); // Screen names must be unique within a cinema
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};
