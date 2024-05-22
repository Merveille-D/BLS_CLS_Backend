<?php

namespace Database\Factories\Litigation;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Litigation\Litigation>
 */
class LitigationFactory extends Factory
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
            'status' => 'created',
            'reference' => $this->faker->word,
            'security' => $this->faker->word,
            'type' => $this->faker->randomElement(['stock', 'vehicle']),
            'phase' => $this->faker->word,
            'contract_id' => $this->faker->uuid(),
            'extra' => $this->faker->text,
            'created_by' => $this->faker->uuid(),
        ];
    }
}
