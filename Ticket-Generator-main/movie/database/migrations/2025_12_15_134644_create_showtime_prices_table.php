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
    Schema::create('showtime_prices', function (Blueprint $table) {
        $table->id();
        $table->foreignId('showtime_id')->constrained()->cascadeOnDelete();
        $table->foreignId('seat_type_id')->constrained()->cascadeOnDelete();
        $table->decimal('price', 8, 2); // 999999.99

        // Price is unique for a Seat Type within a specific Showtime
        $table->unique(['showtime_id', 'seat_type_id']);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtime_prices');
    }
};
