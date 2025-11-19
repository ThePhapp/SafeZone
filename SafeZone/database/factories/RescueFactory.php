<?php

namespace Database\Factories;

use App\Models\Rescue;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RescueFactory extends Factory
{
    protected $model = Rescue::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'status' => fake()->randomElement(['pending', 'in_progress', 'completed', 'cancelled']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'critical']),
            'description' => fake()->paragraph(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
