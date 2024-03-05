<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Credit::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->numberBetween(100, 999),
            'name' => $this->faker->word,
            'default_amount' => $this->faker->numberBetween(100_000, 200_000),
            'default_grant' => $this->faker->numberBetween(10_000, 20_000),
            'default_gnq_extra_amount' => $this->faker->numberBetween(10_000, 50_000),
            'default_lifecycle_extra_amount' => $this->faker->numberBetween(10_000, 50_000),
            'link' => $this->faker->url,
            'respects_housing_units' => $this->faker->boolean,
            'respects_gnq' => $this->faker->boolean,
            'respects_lifecycle' => $this->faker->boolean,
            'min_target_state' => $this->faker->randomElement(['EH 40 EE', 'EH 55 EE', 'EH 70 EE']),
            'valid_until' => $this->faker->dateTimeBetween('+1 year', '+2 years'),
            'valid_from' => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
