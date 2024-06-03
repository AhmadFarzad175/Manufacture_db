<?php

namespace Database\Factories\Sales;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales\Sale>
 */
class SaleFactory extends Factory
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
            'user_id' => rand(1, 10),
            'warehouse_id' => rand(1, 10),
            'invoice_number' => rand(1000, 10000),
            'customer_id' => rand(1, 10),
            'paid' => rand(100, 10000),
            'total' => rand(10000, 200000),
            'status' => rand(0, 2),
            'shipping' => rand(10, 100),
            'discount' => rand(10, 100),
            'tax' => rand(10, 30),
            'currency_id' => rand(1, 10),
            'details' => $this->faker->text,
        ];
    }
}
