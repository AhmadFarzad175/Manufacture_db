<?php

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\TransferDetails>
 */
class TransferDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transfer_id' => rand(1, 10),
            'productMaterial_id' => rand(1, 10),
            'type' => rand(1, 2),
            'quantity' => rand(1,50),
            'unit_cost' => rand(100,10000),
        ];
    }
}
