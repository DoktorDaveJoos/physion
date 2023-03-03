<?php

namespace App\Actions;

use App\Enums\Category;
use App\Models\Order;
use App\Shared\Transferable;
use Illuminate\Pipeline\Pipeline;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateOrderWithProduct
{
    use AsAction;

    public function handle(
        Category $category,
        mixed $data
    ): Order {
        return app(Pipeline::class)
            ->send(Transferable::fromCategory($data, $category))
            ->through([
                CreateCustomer::class,
                CreateCertificate::class,
                CreateOrder::class,
            ])
            ->via('pipeable')
            ->then(fn(Order $data) => $data);
    }
}
