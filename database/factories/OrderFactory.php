<?php

namespace Database\Factories;

use App\Models\Order;
use App\Services\NanoIdCore;
use Hidehalo\Nanoid\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $slug = app(Client::class)->formattedId(NanoIdCore::CUSTOM_SYMBOLS, NanoIdCore::ID_LENGTH);

        return [
            'slug' => $slug,
        ];
    }
}
