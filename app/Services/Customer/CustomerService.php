<?php

declare(strict_types=1);

namespace App\Services\Customer;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

abstract class CustomerService
{

    abstract protected function normalize(mixed $payload): array;

    abstract protected function reference(): string;

    public function handleCustomer(mixed $payload)
    {
        $normalized = $this->normalize($payload);

        $customer = new Customer(
            $normalized['customer']
        );

        $customer->save();

        $order = Order::where($this->reference(), $normalized['reference']);
        $order->paid = true;
        $order->customer()->associate($customer);
        $order->save();

        Log::info(sprintf('%s: Successfully created customer with id [%s]', get_class(), $customer->id));
    }
}
