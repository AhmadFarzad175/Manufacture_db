<?php

namespace Database\Factories\ProductManagements;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductManagements\ProduceDetails>
 */
class ProduceDetailsFactory extends Factory
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
            'produce_id' => rand(1, 10),
            'quantity' => rand(1, 100),
        ];
    }
}
