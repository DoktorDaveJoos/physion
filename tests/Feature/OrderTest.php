<?php

namespace Tests\Feature;

use App\Enums\Category;
use App\Models\Bdrf;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
class OrderTest extends TestCase
{

    use RefreshDatabase;

    public function test_orders_show_can_be_rendered(): void
    {
        Order::factory()
            ->for(Customer::factory()->create())
            ->for(Bdrf::factory()->create(), 'certificate')
            ->create();

        $order = Order::first();

        $response = $this->get('/orders/'.$order->slug);

        $response->assertStatus(200);
    }

    public function test_orders_create_can_be_rendered(): void
    {
        $response = $this->get('/orders/create/'.Category::BDRF->value);

        $response->assertStatus(200);
    }

    public function test_order_can_be_created(): void
    {
        $response = $this->post('/orders/create/'.Category::BDRF->value, [
            // Customer data
            'name' => 'Max Mustermann',
            'email' => 'mustermann@mail.com',

            // Certificate data
            'reason' => 'Modernisierung/Änderung',
            'street_address' => 'Musterstraße 1',
            'zip' => '12345',
            'city' => 'Musterstadt',
            'type' => 'Einfamilienhaus',
            'additional_type' => 'Freistehend',
        ]);

        $response->assertStatus(302);
    }

}
