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
    Schema::create('cinemas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('city_id')->constrained()->cascadeOnDelete();
        $table->string('name');
        $table->string('location'); // Full address
        $table->timestamps();

        $table->unique(['name', 'city_id']); // Cannot have two cinemas with the same name in the same city
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cinemas');
    }
};
