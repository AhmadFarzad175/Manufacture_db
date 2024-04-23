<?php

namespace Database\Factories\Purchases;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchases\PurchaseDetail>
 */
class PurchaseDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'material_id' => rand(1, 10),
            'purchase_id' => rand(1, 10),
            'quantity' => $this->faker->randomNumber(2),
            'unit_cost' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
