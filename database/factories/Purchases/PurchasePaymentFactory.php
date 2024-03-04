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
            'payment_type' => $this->faker->randomElement(['cash', 'bank', 'credit card']),
        ];
    }
}
