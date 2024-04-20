<?php

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\AccountTransfer>
 */
class AccountTransferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from_account_id' => rand(1, 5),
            'to_account_id' => rand(1, 5),
            'user_id' => rand(1, 10),
            'from_amount' => $this->faker->numberBetween(100, 1000),
            'to_amount' => $this->faker->numberBetween(100, 1000),
            'date' => $this->faker->date(),
        ];
    }
}
