<?php

namespace Database\Factories\Purchases;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchases\Purchase>
 */
class PurchaseFactory extends Factory
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
            'supplier_id' => rand(1, 10),
            'paid' => rand(100, 10000),
            'total' => rand(10000, 200000),
            'due' => rand(1000, 20000),
            'status' => $this->faker->randomElement(['received', 'pending', 'ordered']),
            'shipping' => rand(10, 100),
            'discount' => rand(10, 100),
            'tax' => rand(10, 30),
            'currency_id' => rand(1, 3),
            'note' => $this->faker->text,
        ];
    }
}
