<?php

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\Transfer>
 */
class TransferFactory extends Factory
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
            'from_warehouse_id' => rand(1, 10),
            'to_warehouse_id' => rand(1, 10),
            'total' => rand(10000, 200000),
            'status' => rand(0,4),
            'shipping' => rand(10, 100),
            'discount' => rand(10, 100),
            'tax' => rand(10, 30),
            'details' => $this->faker->text,
        ];
    }
}
