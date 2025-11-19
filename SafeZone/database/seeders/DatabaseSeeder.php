<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         // Base demo user
        // Create admin demo user only if not exists
        $admin = User::where('email', 'admin@example.com')->first();
        if (!$admin) {
            $admin = User::factory()->create([
                'name' => 'Admin Demo',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ]);
        }

        // Additional users
        // Create additional users if total user count less than a threshold
        if (User::count() < 6) {
            User::factory(6 - User::count())->create();
        }

        // Call extended sample data seeder (alerts, addresses, etc.)
        $this->call(SampleDataSeeder::class);
    }
}
