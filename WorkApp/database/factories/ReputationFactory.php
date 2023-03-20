<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reputation>
 */
class ReputationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'reputation_score' => fake()->randomDigit(),
            'reputation_message'=> fake()->text(),
            'reputation_by_id' => fake()->randomDigit()	,
            'reputation_to_id' => fake()->randomDigit()
        ];
    }
}
