<?php

namespace Database\Factories\Purchases;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchases\PurchaseExpense>
 */
class PurchaseExpenseFactory extends Factory
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
            'expense_category_id' => rand(1,10),
            'account_id' => rand(1,10),
            'user_id' => rand(1,10),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'details' => $this->faker->text,
        ];
    }
}
