<?php

namespace Database\Factories;

use App\Models\Party;
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
        $partyIDs = Party::pluck('id')->toArray();

        return [
            'date'        => $this->faker->date,
            'party_id'    => $this->faker->randomElement($partyIDs),
            'user_id'     => $this->faker->randomNumber(),
            'send_amount' => $this->faker->randomElement([10000, 20000, 30000, 40000, 50000]),
            'details'     => $this->faker->paragraph,
        ];
    }
}
