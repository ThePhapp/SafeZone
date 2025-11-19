<?php

namespace Database\Factories;

use App\Models\Alert;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlertFactory extends Factory
{
    protected $model = Alert::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->paragraph(),
            'image_path' => 'base.png',
            'type' => fake()->randomElement(['flood', 'fire', 'storm', 'earthquake', 'other']),
            'severity' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'status' => fake()->randomElement(['active', 'resolved', 'cancelled']),
            'radius' => fake()->numberBetween(1000, 10000),
            'issued_at' => now(),
            'created_by' => User::factory(),
        ];
    }

    public function flood(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'flood',
        ]);
    }

    public function fire(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'fire',
        ]);
    }

    public function critical(): static
    {
        return $this->state(fn (array $attributes) => [
            'severity' => 'critical',
        ]);
    }

    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    public function withAddress(): static
    {
        return $this->afterCreating(function (Alert $alert) {
            $alert->address()->create([
                'address_line' => fake()->streetAddress(),
                'district' => fake()->citySuffix(),
                'city' => fake()->city(),
                'province' => fake()->state(),
                'country' => 'Vietnam',
                'postal_code' => fake()->postcode(),
                'latitude' => fake()->latitude(20.5, 21.5),
                'longitude' => fake()->longitude(105.5, 106.5),
            ]);
        });
    }
}
