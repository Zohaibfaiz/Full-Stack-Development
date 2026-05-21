<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    // Create a default admin user (Optional, but useful for login testing later)
    \App\Models\User::factory()->create([
        'name' => 'Super Admin',
        'email' => 'admin@example.com',
        'role' => 'admin', // Make sure you added this column in the migration!
    ]);

    // Run our custom seeders
    $this->call([
        SeatTypeSeeder::class,
        CitySeeder::class,
    ]);
}
}
