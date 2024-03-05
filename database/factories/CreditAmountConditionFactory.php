<?php

namespace Database\Factories;

use App\Models\Credit;
use App\Models\CreditAmountCondition;
use Illuminate\Database\Eloquent\Factories\Factory;

class CreditAmountConditionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CreditAmountCondition::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'condition' => [
                'kids' => 1,
                'salary' => 90_000,
                'max' => 150_000,
            ]
        ];
    }
}
