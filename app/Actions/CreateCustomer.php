<?php

namespace App\Actions;

use App\Models\Customer;
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

    public function pipeable(mixed $data, Closure $next): mixed
    {
        $customer = self::run($data);

        return $next(array_merge($data, [
            'customer_id' => $customer->id,
        ]));
    }
}
