<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeatTypeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seat_types')->insert([
            [
                'name' => 'Standard',
                'description' => 'Regular seating with standard comfort.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'VIP',
                'description' => 'Premium viewing angle with extra legroom.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Couple',
                'description' => 'Double seats in the back row for two people.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}