<?php

namespace Database\Factories\Expenses;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expenses\BillableProduct>
 */
class BillableProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'expense_product_id' => rand(1, 10),
            'billable_expense_id' => rand(1, 10),
            'quantity' => $this->faker->randomNumber(),
            'price' => $this->faker->randomFloat(2, 0, 1000),
        ];
    }
}
