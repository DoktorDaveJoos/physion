<?php

namespace Tests\Unit;

use App\Jobs\ProcessOrder;
use App\Models\ConsumptionCertificate;
use App\Models\Order;
use App\Services\Order\Strategies\ConsumptionStrategy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Ramsey\Uuid\Uuid;
use Tests\CreatesOrderData;
use Tests\TestCase;

class StoreOrderTest extends TestCase
{
    use CreatesOrderData;
    use RefreshDatabase;

    public function test_store_valid_order()
    {
        $uuid = (string)Uuid::uuid4();
        $payload = $this->basePayload()
            ->withAdditional()
            ->withConsumption()
            ->build();

        $processOrder = new ProcessOrder($uuid, $payload);

        App::call([$processOrder, 'handle']);

        $this->assertDatabaseHas('orders', [
            'reference' => $uuid,
        ]);

        $this->assertDatabaseCount('consumption_certificates', 1);

        $order = Order::where('reference', $uuid)->first();

        $this->assertEquals(ConsumptionCertificate::class, $order->product_type);

        $this->assertDatabaseHas('consumptions', [
            'consumption_certificate_id' => $order->product->id,
        ]);

        $this->assertDatabaseHas('additionals', [
            'consumption_certificate_id' => $order->product->id,
        ]);
    }

    public function test_store_valid_with_vacancy() {
        $uuid = (string)Uuid::uuid4();
        $payload = $this->basePayload()
            ->withAdditional()
            ->withConsumption(2)
            ->withVacancy()
            ->build();

        $processOrder = new ProcessOrder($uuid, $payload, new ConsumptionStrategy());

        App::call([$processOrder, 'handle']);

        $this->assertDatabaseHas('orders', [
            'reference' => $uuid,
        ]);

        $this->assertDatabaseCount('consumption_certificates', 1);

        $order = Order::where('reference', $uuid)->first();

        $this->assertEquals(ConsumptionCertificate::class, $order->product_type);

        $this->assertDatabaseHas('consumptions', [
            'consumption_certificate_id' => $order->product->id,
        ]);

        $this->assertDatabaseHas('additionals', [
            'consumption_certificate_id' => $order->product->id,
        ]);

        $this->assertDatabaseHas('vacancies', [
            'consumption_certificate_id' => $order->product->id,
        ]);
    }

    public function test_store_valid_with_vacancy_percentage() {
        $uuid = (string)Uuid::uuid4();
        $payload = $this->basePayload()
            ->withAdditional()
            ->withConsumption(2)
            ->withVacancyPercentage()
            ->build();

        $processOrder = new ProcessOrder($uuid, $payload, new ConsumptionStrategy());

        App::call([$processOrder, 'handle']);

        $this->assertDatabaseHas('orders', [
            'reference' => $uuid,
        ]);

        $this->assertDatabaseCount('consumption_certificates', 1);

        $order = Order::where('reference', $uuid)->first();

        $this->assertEquals(ConsumptionCertificate::class, $order->product_type);

        $this->assertDatabaseHas('consumptions', [
            'consumption_certificate_id' => $order->product->id,
        ]);

        $this->assertDatabaseHas('additionals', [
            'consumption_certificate_id' => $order->product->id,
        ]);

        $this->assertDatabaseHas('vacancies', [
            'consumption_certificate_id' => $order->product->id,
        ]);
    }

    public function test_store_valid_with_cooling() {
        $uuid = (string)Uuid::uuid4();
        $payload = $this->basePayload()
            ->withAdditional(true)
            ->withConsumption()
            ->build();

        $processOrder = new ProcessOrder($uuid, $payload, new ConsumptionStrategy());

        App::call([$processOrder, 'handle']);

        $this->assertDatabaseHas('orders', [
            'reference' => $uuid,
        ]);

        $this->assertDatabaseCount('consumption_certificates', 1);

        $order = Order::where('reference', $uuid)->first();

        $this->assertEquals(ConsumptionCertificate::class, $order->product_type);

        $this->assertDatabaseHas('consumptions', [
            'consumption_certificate_id' => $order->product->id,
        ]);

        $this->assertDatabaseHas('additionals', [
            'consumption_certificate_id' => $order->product->id,
            'cooling' => 'Aus Strom',
            'cooling_count' => 2,
        ]);
    }

    public function test_store_invalid_order()
    {
        $uuid = (string)Uuid::uuid4();

        $payload = [
            "foo" => "bar"
        ];

        $processOrder = new ProcessOrder($uuid, $payload, new ConsumptionStrategy());

        App::call([$processOrder, 'handle']);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseHas('dead_letters', [
            'reference' => $uuid,
        ]);
    }

}
