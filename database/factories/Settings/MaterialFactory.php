<?php

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\Material>
 */
class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->countryCode(),
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'material_category_id' => $this->faker->numberBetween(1, 10),
            'unit_id' => $this->faker->numberBetween(1, 10),
            'cost' => $this->faker->randomNumber(5),
            'stock' => $this->faker->randomNumber(3),
            'stock_alert' => $this->faker->randomNumber(3),
            'description' => $this->faker->paragraph(),
        ];
    }
}
