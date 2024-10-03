<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'about_us' => $this->faker->text,
            'why_us' => $this->faker->text,
            'goal' => $this->faker->text,
            'vision' => $this->faker->text,
            'about_footer' => $this->faker->text,
            'ads_text' => $this->faker->text,
        ];
    }
}
