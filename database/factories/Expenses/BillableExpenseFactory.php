<?php

namespace Database\Factories\Expenses;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expenses\BillableExpense>
 */
class BillableExpenseFactory extends Factory
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
            'expense_people_id' => rand(1, 10),
            'supplier_id' => rand(1, 10),
            'user_id' => rand(1, 10),
            'invoice_number' => $this->faker->randomNumber(),
            'paid' => $this->faker->randomFloat(2, 100, 1000),
            'total' => $this->faker->randomFloat(2, 1000, 100000),
            'due' => $this->faker->randomFloat(2, 1000, 100000),
            'currency_id' => rand(1, 10),
            'details' => $this->faker->text,
        ];
    }
}
