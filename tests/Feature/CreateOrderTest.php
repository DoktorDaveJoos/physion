<?php

namespace Tests\Feature;

use App\Jobs\ProcessOrder;
use App\Jobs\ProcessPayment;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Process\Process;
use Tests\CreatesOrderData;
use Tests\TestCase;

class CreateOrderTest extends TestCase
{

    use CreatesOrderData;

    public function test_create_order()
    {
        Queue::fake();

        $payload = $this->basePayload()
            ->withAdditional(true)
            ->withConsumption()
            ->build();

        $response = $this->post('/api/order', $payload);
        $response->assertStatus(200);

        $this->assertTrue(self::isUUID($response->json('reference')));

        Queue::assertPushed(ProcessOrder::class);
    }

    private static function isUUID($string): bool
    {
        return preg_match(
                '/^[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/',
                $string
            ) === 1;
    }
}
