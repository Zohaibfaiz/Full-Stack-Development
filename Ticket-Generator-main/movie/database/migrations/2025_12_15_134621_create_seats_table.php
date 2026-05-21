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
    Schema::create('seats', function (Blueprint $table) {
        $table->id();
        $table->foreignId('screen_id')->constrained()->cascadeOnDelete();
        $table->foreignId('seat_type_id')->constrained(); // Links to the pricing tier
        $table->char('row', 1); // A, B, C, etc.
        $table->integer('number'); // 1, 2, 3, etc.
        $table->timestamps();

        $table->unique(['screen_id', 'row', 'number']); // A seat is unique by its position in a screen
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seats');
    }
};
