<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\Customer;
use App\Models\Order;
use InvalidArgumentException;
use Throwable;

class FindCertificate implements Action
{

    /**
     * @param  mixed  ...$arguments
     * @return mixed
     * @throws Throwable
     */
    public static function handle(...$arguments): array
    {
        if (count($arguments) === 1) {
            return (new static())::handleByOrderId($arguments[0]);
        }

        if (count($arguments) === 2) {
            return (new static())::handleByEmail($arguments[0], $arguments[1]);
        }

        throw new InvalidArgumentException(__METHOD__.' expects 1 or 2 arguments, '.count($arguments).' given.');
    }

    private static function handleByEmail(string $email, string $zip): array
    {
        $customer = Customer::where('email', $email)->first();

        if ($customer) {
            return $customer->orders->filter(function ($order) use ($zip) {
                return $order->product->zip === $zip;
            })->toArray();
        }

        return [];
    }

    private static function handleByOrderId(string $order_id): array
    {
        $order = Order::find($order_id);

        if ($order) {
            return [$order];
        }

        return [];
    }

}
