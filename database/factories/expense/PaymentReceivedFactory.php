<?php

namespace Database\Factories;

use App\Models\Party;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PaymentReceived>
 */
class PaymentReceivedFactory extends Factory
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
            'user_id' => $this->faker->numberBetween(1, 10),
            'amount' => $this->faker->randomElement([10000, 20000, 30000, 40000, 50000]),
            'details'     => $this->faker->paragraph,
        ];
    }
}
