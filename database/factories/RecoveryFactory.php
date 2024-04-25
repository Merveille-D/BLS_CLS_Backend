<?php

namespace Database\Factories;

use App\Models\Recovery\Recovery;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RecoveryFactory extends Factory
{
    protected $model = Recovery::class;
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
            'status' => $this->faker->randomElement(['created']),
            'type' => $this->faker->randomElement(['friendly', 'forced']),
            'has_guarantee' => $this->faker->boolean(),
            'guarantee_id' => $this->faker->uuid(),

        ];
    }
}
