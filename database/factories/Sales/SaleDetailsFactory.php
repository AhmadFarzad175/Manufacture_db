<?php

namespace Database\Factories\Sales;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales\SaleDetails>
 */
class SaleDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => rand(1, 10),
            'sale_id' => rand(1, 10),
            'quantity' => $this->faker->randomNumber(2),
            'unit_cost' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
