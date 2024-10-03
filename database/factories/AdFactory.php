<?php

namespace Database\Factories;

use App\Models\Domain;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ad>
 */
class AdFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'slug' => $this->faker->slug,
            'text' => $this->faker->text,
            'phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement([0, 1]),
            'user_id' => User::factory(),
            'domain_id' => Domain::factory(),
        ];
    }
}
