<?php

namespace Database\Factories\Sales;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sales\SalePayment>
 */
class SalePaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'user_id' => rand(1,10),
            'reference' => rand(1,10),
            'sale_id' => rand(1,10),
            'account_id' => rand(1,10),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'details' => $this->faker->paragraph,
        ];
    }
}
