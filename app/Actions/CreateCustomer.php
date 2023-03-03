<?php

namespace App\Actions;

use App\Models\Customer;
use App\Shared\Transferable;
use Closure;
use Exception;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateCustomer
{
    use AsAction;

    /**
     * @throws Exception
     */
    public function handle(mixed $data)
    {
        return Customer::firstOrCreate([
            'email' => $data['email'],
        ], $data);
    }

    public function pipeable(Transferable $transferable, Closure $next): mixed
    {
        $customer = self::run($transferable->getData());

        return $next(
            Transferable::fromCustomer(
                $transferable->getData(),
                $transferable->getCategory(),
                $customer
            )
        );
    }
}
