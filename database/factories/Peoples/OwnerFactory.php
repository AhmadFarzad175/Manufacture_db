<?php

namespace Database\Factories\Peoples;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peoples\Owner>
 */
class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->email(),
            'phone'   => $this->faker->numerify('07########'),
            'share' => rand(1, 100),
            'asset' => rand(10000, 1000000),
        ];
    }
}
