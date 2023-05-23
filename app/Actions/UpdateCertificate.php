<?php

namespace App\Actions;

use App\Models\Order;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateCertificate
{
    use AsAction;

    /**
     * Updates a certificate based on the category with previous validated data.
     *
     * @param  Order  $order
     * @param  mixed  $data  The validated data
     *
     * @return void
     */
    public function handle(Order $order, mixed $data): void
    {
        $order->certificate->update($data);
        $order->setStep($data['page']);
    }
}
