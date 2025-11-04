<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'short_description' => fake()->text(),
            'primary_type' => 'main_company',
            'url' => fake()->url(),
            'address_1' => fake()->address(),
            'address_2' => fake()->streetName(),
            'address_3' => fake()->postcode(),
            'telephone_1' => fake()->phoneNumber(),
        ];
    }
}
