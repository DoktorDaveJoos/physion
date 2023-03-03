<?php

namespace Database\Factories;

use App\Models\Vrbr;
use App\Services\NanoIdCore;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vrbr>
 */
class VrbrFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reason' => 'Modernisierung/Änderung',
            'street_address' => $this->faker->streetAddress,
            'zip' => $this->faker->postcode,
            'city' => $this->faker->city,
            'type' => $this->faker->randomElement(['Einfamilienhaus', 'Mehrfamilienhaus']),
            'additional_type' => $this->faker->randomElement(['Doppelhaushälfte', 'Reihenhaus']),
        ];
    }
}
