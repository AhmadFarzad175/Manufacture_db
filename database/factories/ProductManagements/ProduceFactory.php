<?php

namespace Database\Factories\ProductManagements;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductManagements\Produce>
 */
class ProduceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'warehouse_id' => rand(1, 10),
            'details' => $this->faker->text,
        ];
    }
}
