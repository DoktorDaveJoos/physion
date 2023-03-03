<?php

namespace App\Actions;

use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGeneral
{
    use AsAction;

    public function handle(Order $order, mixed $data): void
    {
        $order->customer->update($data);
        $order->certificate->update($data);
    }
}
