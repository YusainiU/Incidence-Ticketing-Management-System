<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PharIo\Manifest\Email;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /*
        $table->string('name');
        $table->string('address_1');
        $table->string('address_2')->nullable();
        $table->string('address_3')->nullable();
        $table->string('address_4')->nullable();
        $table->string('telephone')->nullable();
        $table->string('email')->nullable();
        $table->string('url')->nullable();
        */

        return [
            'name' => fake()->company(),
            'address_1' => fake()->address(),
            'address_2' => fake()->streetAddress(),
            'address_3' => fake()->postcode(),
            'telephone' => fake()->phoneNumber(),
            'email' => fake()->email(),
            'url' => fake()->url(),
        ];
    }
}
