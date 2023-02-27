<?php

namespace App\Actions;

use App\Models\Order;
use App\Services\NanoIdCore;
use Closure;
use Hidehalo\Nanoid\Client;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrder
{
    use AsAction;

    public function __construct(
        private readonly Client $nanoClient,
    ) {
    }

    public function handle(mixed $data)
    {
        return Order::create(
            array_merge($data, [
                'id' => $this->nanoClient->formattedId(NanoIdCore::CUSTOM_SYMBOLS, NanoIdCore::ID_LENGTH),
                'product_id' => $data['certificate_id'],
                'product_type' => $data['category']->getHandler(),
            ])
        );
    }

    public function pipeable(mixed $data, Closure $next): mixed
    {
        $order = self::run($data);

        return $next(
            array_merge($data, [
                'order_id' => $order->id,
            ])
        );
    }
}
