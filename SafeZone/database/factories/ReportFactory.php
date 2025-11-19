<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\User;
use App\Models\Alert;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'alert_id' => Alert::factory(),
            'description' => fake()->paragraph(),
            'image_path' => fake()->optional()->imageUrl(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
