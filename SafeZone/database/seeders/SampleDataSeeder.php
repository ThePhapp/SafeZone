<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Alert;
use App\Models\Address;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        $types = ['flood','fire','earthquake','storm'];
        $severities = ['low','medium','high','critical'];

        foreach (range(1,6) as $i) {
            $creator = $users->random();
            $alert = Alert::create([
                'title' => ucfirst($types[$i % count($types)]) . " Alert #$i",
                'description' => 'Sample description for alert #' . $i,
                'type' => $types[$i % count($types)],
                'severity' => $severities[array_rand($severities)],
                'radius' => rand(500, 2500),
                'issued_at' => Carbon::now()->subMinutes(rand(5,120)),
                'created_by' => $creator->id,
            ]);

            $baseLat = 21.0278; // Hanoi approx
            $baseLng = 105.8342;
            $offsetLat = ($i * 0.005) * (rand(0,1) ? 1 : -1);
            $offsetLng = ($i * 0.005) * (rand(0,1) ? 1 : -1);

            $alert->address()->create([
                'address_line' => 'Sample Street ' . $i,
                'district' => 'District ' . $i,
                'city' => 'Hà Nội',
                'province' => 'Hà Nội',
                'country' => 'Việt Nam',
                'postal_code' => '100000',
                'formatted_address' => 'Sample Street ' . $i . ', Hà Nội, Việt Nam',
                'latitude' => $baseLat + $offsetLat,
                'longitude' => $baseLng + $offsetLng,
            ]);
        }

        foreach ($users as $user) {
            if ($user->addresses()->count() === 0) {
                $user->addresses()->create([
                    'address_line' => 'User Home ' . $user->id,
                    'district' => 'Demo District',
                    'city' => 'Hà Nội',
                    'province' => 'Hà Nội',
                    'country' => 'Việt Nam',
                    'postal_code' => '100000',
                    'formatted_address' => 'User Home ' . $user->id . ', Hà Nội',
                    'latitude' => 21.02 + mt_rand(-100,100)/10000,
                    'longitude' => 105.83 + mt_rand(-100,100)/10000,
                ]);
            }
        }
    }
}
