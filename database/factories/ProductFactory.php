<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\product>
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
            'product_code' => fake()->randomDigit(),
            'name' => strtoupper(fake()->text(10)),
            'short_description' => fake()->text(50),
            'model' => strtoupper(fake()->text(10)),
            'type' => 'Network',
            'make' => 'British Telecoms',
            'version' => fake()->randomDigit(),
        ];
    }
}
