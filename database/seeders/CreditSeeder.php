<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Credit;
use App\Models\CreditAmountCondition;
use App\Models\CreditCondition;
use Illuminate\Database\Seeder;

class CreditSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        CreditAmountCondition::query()->delete();
        CreditCondition::query()->delete();
        Credit::query()->delete();

        Credit::factory()->has(
            CreditCondition::factory()
                ->count(3)
                ->sequence(
                    [
                        'interest' => 4.29,
                        'interest_rate_fixation' => 5,
                        'duration_from' => 4,
                        'duration_to' => 25,
                        'waiting_period_from' => 1,
                        'waiting_period_to' => 3,
                    ],
                    [
                        'interest' => 4.32,
                        'interest_rate_fixation' => 10,
                        'duration_from' => 4,
                        'duration_to' => 25,
                        'waiting_period_from' => 1,
                        'waiting_period_to' => 3,
                    ],
                    [
                        'interest' => 4.29,
                        'interest_rate_fixation' => 5,
                        'duration_from' => 26,
                        'duration_to' => 35,
                        'waiting_period_from' => 1,
                        'waiting_period_to' => 5,
                    ],
                )
        )->create([
            'key' => 124,
            'name' => 'KFW 124',
            'default_amount' => 100000,
            'default_grant' => 0,
            'default_gnq_extra_amount' => 0,
            'default_lifecycle_extra_amount' => 0,
            'respects_housing_units' => false,
            'respects_gnq' => false,
            'respects_lifecycle' => false,
        ]);


        Credit::factory()
            ->has(
                CreditCondition::factory()
                    ->count(3)
                    ->sequence(
                        [
                            'interest' => 0.47,
                            'interest_rate_fixation' => 10,
                            'duration_from' => 4,
                            'duration_to' => 10,
                            'waiting_period_from' => 1,
                            'waiting_period_to' => 2,
                        ],
                        [
                            'interest' => 1.58,
                            'interest_rate_fixation' => 10,
                            'duration_from' => 11,
                            'duration_to' => 20,
                            'waiting_period_from' => 1,
                            'waiting_period_to' => 3,
                        ],
                        [
                            'interest' => 1.86,
                            'interest_rate_fixation' => 10,
                            'duration_from' => 21,
                            'duration_to' => 30,
                            'waiting_period_from' => 1,
                            'waiting_period_to' => 5,
                        ],
                    )
            )
            ->has(
                CreditAmountCondition::factory()
                    ->count(3)
                    ->sequence(
                        [
                            'condition' => [
                                'target' => 'EH 40',
                                'grant' => 0.2,
                                'max' => 120_000,
                            ],
                        ],
                        [
                            'condition' => [
                                'target' => 'EH 40 EE',
                                'grant' => 0.25,
                                'max' => 150_000,
                            ],
                        ],
                        [
                            'condition' => [
                                'target' => 'EH 55',
                                'grant' => 0.15,
                                'max' => 120_000,
                            ],
                        ],
                    )
            )
            ->create([
                'key' => 261,
                'name' => 'KFW 261',
                'default_amount' => null,
                'default_grant' => null,
                'default_gnq_extra_amount' => null,
                'default_lifecycle_extra_amount' => null,
                'respects_housing_units' => true,
                'respects_gnq' => false,
                'respects_lifecycle' => false,
            ]);

        Credit::factory()
            ->has(
                CreditCondition::factory()
                    ->count(3)
                    ->sequence(
                        [
                            'interest' => 0.1,
                            'interest_rate_fixation' => 10,
                            'duration_from' => 4,
                            'duration_to' => 10,
                            'waiting_period_from' => 1,
                            'waiting_period_to' => 2,
                        ],
                        [
                            'interest' => 0.99,
                            'interest_rate_fixation' => 10,
                            'duration_from' => 11,
                            'duration_to' => 20,
                            'waiting_period_from' => 1,
                            'waiting_period_to' => 3,
                        ],
                        [
                            'interest' => 1.23,
                            'interest_rate_fixation' => 10,
                            'duration_from' => 21,
                            'duration_to' => 30,
                            'waiting_period_from' => 1,
                            'waiting_period_to' => 5,
                        ],
                    )
            )
            ->has(
                CreditAmountCondition::factory()
                    ->count(3)
                    ->sequence(
                        [
                            'condition' => [
                                'kids' => 1,
                                'salary' => 90_000,
                                'max' => 170_000,
                            ],
                        ],
                        [
                            'condition' => [
                                'kids' => 2,
                                'salary' => 100_000,
                                'max' => 170_000,
                            ],
                        ],
                        [
                            'condition' => [
                                'kids' => 3,
                                'salary' => 110_000,
                                'max' => 200_000,
                            ],
                        ],
                    )
            )
            ->create([
                'key' => 300,
                'name' => 'KFW 300',
                'default_amount' => null,
                'default_grant' => null,
                'default_gnq_extra_amount' => null,
                'default_lifecycle_extra_amount' => null,
                'respects_housing_units' => true,
                'respects_gnq' => false,
                'respects_lifecycle' => false,
            ]);
    }
}
