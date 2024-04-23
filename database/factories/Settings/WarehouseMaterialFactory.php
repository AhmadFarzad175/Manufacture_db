<?php

namespace Database\Factories\Settings;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Settings\WarehouseMaterial>
 */
class WarehouseMaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'material_id' => rand(1, 10),
            'warehouse_id' => rand(1, 10),
            'quantity' => rand(1, 100),
        ];
    }
}
