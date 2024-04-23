<?php

namespace Database\Factories\Finances;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Finances\ExpensePaymentSent>
 */
class ExpensePaymentSentFactory extends Factory
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
            'expense_people_id' => rand(1,10),
            'account_id' => rand(1,10),
            'user_id' => rand(1,10),
            'amount' => $this->faker->randomFloat(2, 0, 1000),
            'details' => $this->faker->text,
        ];
    }
}
