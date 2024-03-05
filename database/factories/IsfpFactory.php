<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class IsfpFactory extends Factory
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
            'isfp_path' => 'isfp.pdf',
            'power_of_attorney_path' => 'vollmacht.pdf',
        ];
    }
}
