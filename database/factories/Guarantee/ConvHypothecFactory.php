<?php

namespace Database\Factories\Guarantee;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guarantee\ConvHypothec>
 */
class ConvHypothecFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'reference' => $this->faker->unique()->randomNumber,
            'contract_id' => $this->faker->uuid(),
            'state' => 'created',
        ];
    }
}
