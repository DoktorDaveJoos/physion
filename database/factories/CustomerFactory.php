<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'address_line_1' => $this->faker->streetAddress,
            'address_line_2' => null,
            'zip' => $this->faker->postcode,
            'city' => $this->faker->city,
            'state' => null,
            'country' => null,
        ];
    }
}
