<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\CreditCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'interest' => $this->faker->randomFloat(2, 1, 10),
            'interest_rate_fixation' => $this->faker->numberBetween(1, 10),
            'duration_from' => $this->faker->numberBetween(1, 10),
            'duration_to' => $this->faker->numberBetween(10, 30),
            'waiting_period_from' => $this->faker->numberBetween(1, 3),
            'waiting_period_to' => $this->faker->numberBetween(3, 5),
        ];
    }
}
