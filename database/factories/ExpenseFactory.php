<?php

namespace Database\Factories;

use App\Models\Party;
use App\Models\Branch;
use App\Models\ExpenseCategory;
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
        $expenseCategoryIds = ExpenseCategory::pluck('id')->toArray();
        $branchIDs = Branch::pluck('id')->toArray();
        $partyIDs = Party::pluck('id')->toArray();

        return [
            'date' => $this->faker->date(),
            'expense_category_id' => $this->faker->randomElement($expenseCategoryIds),
            'user_id' => $this->faker->numberBetween(1, 10),
            'party_id' => $this->faker->randomElement($partyIDs),
            'details' => $this->faker->paragraph(1),
            'amount' => $this->faker->randomElement([10000, 20000, 30000, 40000, 50000]),
            'branch_id' => $this->faker->randomElement($branchIDs),
        ];
    }
}
