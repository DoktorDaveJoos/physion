<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class BzaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'building_id' => 1,
            'customer_id' => 1,
            'product_id' => 1,
            'status' => 'created',
            'target' => 'EH40 EE',
            'bza_number' => 'BZA-2021-0001',
            'bza_path' => 'bza.pdf',
            'power_of_attorney_path' => 'vollmacht.pdf',
        ];
    }
}
