<?php

namespace Database\Factories;

use App\Models\PaymentSent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<PaymentSent>
 */
class PaymentSentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'date'        => $this->faker->date,
            'expense_people_id'    => rand(1, 10),
            'user_id' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->randomElement([10000, 20000, 30000, 40000, 50000]),
            'details'     => $this->faker->paragraph,
        ];
    }
}
