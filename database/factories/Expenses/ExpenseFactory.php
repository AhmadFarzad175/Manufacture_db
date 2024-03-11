<?php

namespace Database\Factories\Expenses;


use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
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
            'expense_category_id' => rand(1, 10),
            'user_id' => rand(1, 10),
            'expense_people_id' => rand(1, 10),
            'details' => $this->faker->paragraph(1),
            'amount' => $this->faker->randomElement([10000, 20000, 30000, 40000, 50000]),
        ];
    }
}
