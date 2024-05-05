<?php

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\AdjustmentDetails>
 */
class AdjustmentDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'adjustment_id' => rand(1, 10),
            'productMaterial_id' => rand(1, 10),
            'type' => $this->faker->boolean(),
            'kind' => $this->faker->boolean(),
            'amount' => rand(1,50),
        ];
    }
}
