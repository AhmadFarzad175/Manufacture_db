<?php

namespace Database\Factories\Purchases;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchases\PurchasePayment>
 */
class PurchasePaymentFactory extends Factory
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
            'purchase_id' => rand(1,10),
            'account_id' => rand(1,10),
            'amount' => $this->faker->randomFloat(2, 0, 10000),
            'details' => $this->faker->paragraph,
        ];
    }
}
