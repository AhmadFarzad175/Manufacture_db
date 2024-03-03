<?php

namespace Database\Factories\Products;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->numberBetween(1, 100),
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'material_category_id' => $this->faker->numberBetween(1, 10),
            'unit_id' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomNumber(5),
            'stock' => $this->faker->randomNumber(3),
            'stock_alert' => $this->faker->randomNumber(3),
            'tax_type' => $this->faker->boolean(),
            'description' => $this->faker->paragraph,
        ];
    }
}
